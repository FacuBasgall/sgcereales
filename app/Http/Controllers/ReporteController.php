<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReporteExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\ReporteSendMail;

use App\Reporte;
use App\Filtro;
use App\Aviso;
use App\Descarga;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Titular;
use App\Titular_Contacto;
use App\Remitente_Contacto;
use App\Corredor_Contacto;
use App\Intermediario;
use App\Remitente_Comercial;
use App\User;
use App\Aviso_Producto;
use App\Aviso_Entregador;
use App\Entregador_Contacto;
use App\Entregador_Domicilio;
use App\Localidad;
use App\Provincia;
use App\Usuario_Preferencias_Correo;

use Datatables;
use DB;
use Mail;
use SweetAlert;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('entregador');
    }

    public function summary(Request $request)
    /**Resumen de Descargas en Avisos terminados */
    {
        $resultado = NULL;
        $filtros = array(
            "fechaDesde" => $request->fechaDesde,
            "fechaHasta" => $request->fechaHasta,
            "titular" => $request->titular,
            "intermediario" => $request->intermediario,
            "remitente" => $request->remitente,
            "corredor" => $request->corredor,
            "destinatario" => $request->destinatario,
            "entregador" => $request->entregador,
            "producto" => $request->producto,
        );
        $control = false;

        $idEntregador = auth()->user()->idUser;

        $reportesBD = Reporte::all();
        foreach ($reportesBD as $report) {
            $report->delete(); //vaciar la tabla reportes-temp
        }

        $filtrosBD = Filtro::all();
        foreach ($filtrosBD as $filt) {
            $filt->delete(); //vaciar la tabla filtro-reporte-temp
        }

        if (isset($request->fechaDesde) && isset($request->fechaHasta)) {
            if ($request->fechaDesde <= $request->fechaHasta) {
                $existe = Aviso_Entregador::whereBetween('fecha', [$request->fechaDesde, $request->fechaHasta])->where('idEntregador', $idEntregador)->exists();
                if ($existe) {
                    $control = true;
                    $resultado = DB::table('aviso')
                        ->join('aviso_entregador', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                        ->whereBetween('aviso_entregador.fecha', [$request->fechaDesde, $request->fechaHasta])
                        ->where('aviso_entregador.idEntregador', '=', $idEntregador)
                        ->where('aviso.estado', '=', true)
                        ->select('aviso.*')
                        ->get();
                }
                $nuevoFiltro = new Filtro;
                $nuevoFiltro->fechaDesde = $filtros["fechaDesde"];
                $nuevoFiltro->fechaHasta = $filtros["fechaHasta"];
                $nuevoFiltro->idTitular = $filtros["titular"];
                $nuevoFiltro->idIntermediario = $filtros["intermediario"];
                $nuevoFiltro->idRemitente = $filtros["remitente"];
                $nuevoFiltro->idCorredor = $filtros["corredor"];
                $nuevoFiltro->idDestinatario = $filtros["destinatario"];
                $nuevoFiltro->entregador = $filtros["entregador"];
                $nuevoFiltro->idProducto = $filtros["producto"];
                $nuevoFiltro->save();
            } else {
                alert()->warning("La fecha desde debe ser menor a la fecha hasta", 'Ha ocurrido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }
        if ($control) {
            if (isset($request->titular)) {
                $resultado = $resultado->where('idTitularCartaPorte', $request->titular);
            }
            if (isset($request->corredor)) {
                $resultado = $resultado->where('idCorredor', $request->corredor);
            }
            if (isset($request->intermediario)) {
                $resultado = $resultado->where('idIntermediario', $request->intermediario);
            }
            if (isset($request->remitente)) {
                $resultado = $resultado->where('idRemitenteComercial', $request->remitente);
            }
            if (isset($request->destinatario)) {
                $resultado = $resultado->where('idDestinatario', $request->destinatario);
            }
            if (isset($request->entregador)) {
                $resultado = $resultado->where('entregador', $request->entregador);
            }
            if (isset($request->producto)) {
                $resultado = $resultado->where('idProducto', $request->producto);
            }
            foreach ($resultado as $result) {
                $nuevoReporte = new Reporte;
                $nuevoReporte->idAviso = $result->idAviso;
                $nuevoReporte->idFiltro = $nuevoFiltro->idFiltro;
                $nuevoReporte->save();
            }
        }
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinatarios = Destino::where('borrado', false)->get();
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregador = User::where('idUser', $idEntregador)->first(); //Solo Usuario Entregador Autenticado
        $productos = Producto::where('borrado', false)->get();
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::where('idEntregador', $idEntregador)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('reporte.summary', compact([
            'cargas', 'descargas', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'entregador', 'productos', 'avisos_productos',
            'avisos_entregadores', 'localidades', 'provincias', 'resultado', 'filtros'
        ]));
    }

    public function export_excel()
    /**Exportar a Excel -> Resumen de Descargas en Avisos terminados */
    {
        $hoy = date("Y-m-d");
        $filename = "Reporte General de Descargas " . $hoy . ".xlsx";
        $filtro = Filtro::first();
        return Excel::download(new ReporteExport($filtro->idFiltro), $filename);
    }

    public function export_pdf()
    /**Exportar a PDF -> Resumen de Descargas en Avisos terminados */
    {
        $hoy = date("Y-m-d");
        $filename = "Reporte General de Descargas " . $hoy . ".pdf";
        $entregadorAutenticado = auth()->user()->idUser;
        $filtros = Filtro::first();
        $resultados = DB::table('reporte-temp')
            ->join('aviso', 'reporte-temp.idAviso', '=', 'aviso.idAviso')
            ->join('aviso_entregador',  'aviso.idAviso', '=', 'aviso_entregador.idAviso')
            ->join('aviso_producto', 'aviso.idAviso', '=', 'aviso_producto.idAviso')
            ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
            ->select('reporte-temp.*', 'aviso.*', 'aviso_producto.*', 'aviso_entregador.*')
            ->get();
        $descargas = DB::table('descarga')
            ->join('carga', 'carga.idCarga', '=', 'descarga.idCarga')
            ->join('reporte-temp', 'reporte-temp.idAviso', '=', 'carga.idAviso')
            ->select('descarga.*', 'reporte-temp.idAviso')
            ->get();
        $titulares = Titular::where('borrado', false)->get();
        $destinatarios = Destino::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $productos = Producto::where('borrado', false)->get();
        $entregador = User::where('idUser', $entregadorAutenticado)->first(); //Solo Usuario Entregador Autenticado
        $localidades = Localidad::all();
        $provincias = Provincia::all();
        $entregador_contacto = Entregador_Contacto::where('idUser', $entregadorAutenticado)->get();
        $entregador_domicilio = Entregador_Domicilio::where('idUser', $entregadorAutenticado)->get();

        $pdf = PDF::loadView('exports.reporte-pdf', compact([
            'resultados', 'descargas', 'filtros', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'productos', 'entregador', 'localidades', 'provincias',
            'entregador_contacto', 'entregador_domicilio'
        ]));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download($filename);
    }

    public function send_email(Request $request)
    /**Enviar por Correo -> Resumen de Descargas en Avisos terminados */
    {
        $correos = array();
        foreach ($request->email as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $correos[] = $email;
            }
        }
        $asunto = $request->asunto;
        $cuerpo = $request->cuerpo;
        \Mail::to($correos)->send(new ReporteSendMail($asunto, $cuerpo));
        alert()->success("El reporte general ha sido enviado con éxito", 'Correo enviado');
        return redirect()->action('ReporteController@summary');
    }

    public function load_email()
    {
        /**CARGA DE TODOS LOS CORREOS DE TODAS LAS PERSONAS */
        $correosTitular = DB::table('reporte-temp')
            ->rightJoin('aviso', 'aviso.idAviso', '=', 'reporte-temp.idAviso')
            ->rightJoin('titular_contacto', 'titular_contacto.cuit', '=', 'aviso.idTitularCartaPorte')
            ->where('titular_contacto.tipo', '=', 3)
            ->distinct()
            ->select('titular_contacto.contacto')
            ->get();
        $correosCorredor = DB::table('reporte-temp')
            ->rightJoin('aviso', 'aviso.idAviso', '=', 'reporte-temp.idAviso')
            ->rightJoin('corredor_contacto', 'corredor_contacto.cuit', '=', 'aviso.idCorredor')
            ->where('corredor_contacto.tipo', '=', 3)
            ->distinct()
            ->select('corredor_contacto.contacto')
            ->get();
        $correosRemitente = DB::table('reporte-temp')
            ->rightJoin('aviso', 'aviso.idAviso', '=', 'reporte-temp.idAviso')
            ->rightJoin('remitente_contacto', 'remitente_contacto.cuit', '=', 'aviso.idRemitenteComercial')
            ->where('remitente_contacto.tipo', '=', 3)
            ->distinct()
            ->select('remitente_contacto.contacto')
            ->get();
        $correosIntermediario = DB::table('reporte-temp')
            ->rightJoin('aviso', 'aviso.idAviso', '=', 'reporte-temp.idAviso')
            ->rightJoin('intermediario_contacto', 'intermediario_contacto.cuit', '=', 'aviso.idIntermediario')
            ->where('intermediario_contacto.tipo', '=', 3)
            ->distinct()
            ->select('intermediario_contacto.contacto')
            ->get();
        $correosDestinatario = DB::table('reporte-temp')
            ->rightJoin('aviso', 'aviso.idAviso', '=', 'reporte-temp.idAviso')
            ->rightJoin('destinatario_contacto', 'destinatario_contacto.cuit', '=', 'aviso.idDestinatario')
            ->where('destinatario_contacto.tipo', '=', 3)
            ->distinct()
            ->select('destinatario_contacto.contacto')
            ->get();

        /**COPIA AL ARRAY */
        $correos = array();
        foreach ($correosTitular as $titular) {
            $correos[] = $titular->contacto;
        }
        foreach ($correosRemitente as $remitente) {
            $correos[] = $remitente->contacto;
        }
        foreach ($correosCorredor as $corredor) {
            $correos[] = $corredor->contacto;
        }
        foreach ($correosIntermediario as $intermediario) {
            $correos[] = $intermediario->contacto;
        }
        foreach ($correosDestinatario as $destinatario) {
            $correos[] = $destinatario->contacto;
        }

        /**ELIMINAR LOS CORREOS REPETIDOS */
        $correos = array_unique($correos);
        $entregadorAutenticado = auth()->user()->idUser;
        $user_preferencias = Usuario_Preferencias_Correo::where('idUser', $entregadorAutenticado)->first();
        $user_email = Entregador_Contacto::where('id', $user_preferencias->email)->first();

        return view('reporte.mail', compact(['correos', 'user_email']));
    }

    public function products(Request $request)
    {
        /**FORMULAS
         *   NETO KG = BRUTO - TARA
            MERMA % = MERMA HUMEDAD + MERMA MANIPULEO
            MERMA KG = NETO KG x (MERMA % / 100)
            NETO FINAL = NETO KG - MERMA KG
            DIFERENCIA = NETO FINAL - KG CARGA
         */
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $control = 0;
        $entregadorAutenticado = auth()->user()->idUser;
        $arrayProductos[] = ['Nombre del Producto', 'Total Descargado (Kg)', 'Total Descargado con Merma (Kg)'];
        if ($fechaDesde <= $fechaHasta) {
            $query = DB::table('aviso')
                ->join('carga', 'carga.idAviso', '=', 'aviso.idAviso')
                ->join('descarga', 'descarga.idCarga', '=', 'carga.idCarga')
                ->join('producto', 'producto.idProducto', '=', 'aviso.idProducto')
                ->join('aviso_entregador', 'aviso_entregador.idAviso', '=', 'aviso.idAviso')
                ->where('aviso.estado', '=', 1) //avisos terminados
                ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
                ->whereBetween('aviso_entregador.fecha', [$fechaDesde, $fechaHasta])
                ->select('producto.nombre', 'producto.mermaManipuleo', 'descarga.bruto', 'descarga.tara', 'descarga.merma')
                ->orderBy('producto.nombre')
                ->get();

            if (sizeof($query) > 0) {
                $control = 1;
                $girasol = array('Nombre' => 'Girasol', 'Neto' => 0, 'NetoFinal' => 0);
                $maiz = array('Nombre' => 'Maiz', 'Neto' => 0, 'NetoFinal' => 0);
                $soja = array('Nombre' => 'Soja', 'Neto' => 0, 'NetoFinal' => 0);
                $sorgo = array('Nombre' => 'Sorgo', 'Neto' => 0, 'NetoFinal' => 0);
                $trigo = array('Nombre' => 'Trigo', 'Neto' => 0, 'NetoFinal' => 0);
                foreach ($query as $q) {
                    switch ($q->nombre) {
                        case 'Girasol':
                            $girasol['Neto'] += $q->bruto - $q->tara;
                            $girasol['NetoFinal'] += ($q->bruto - $q->tara) - (($q->bruto - $q->tara) * ($q->merma / 100));
                            break;
                        case 'Maiz':
                            $maiz['Neto'] += $q->bruto - $q->tara;
                            $maiz['NetoFinal'] += ($q->bruto - $q->tara) - ($q->bruto - $q->tara) * ($q->merma / 100);
                            break;
                        case 'Soja':
                            $soja['Neto'] += $q->bruto - $q->tara;
                            $soja['NetoFinal'] += ($q->bruto - $q->tara) - ($q->bruto - $q->tara) * ($q->merma / 100);
                            break;
                        case 'Sorgo':
                            $sorgo['Neto'] += $q->bruto - $q->tara;
                            $sorgo['NetoFinal'] += ($q->bruto - $q->tara) - ($q->bruto - $q->tara) * ($q->merma / 100);
                            break;
                        case 'Trigo':
                            $trigo['Neto'] += $q->bruto - $q->tara;
                            $trigo['NetoFinal'] += ($q->bruto - $q->tara) - ($q->bruto - $q->tara) * ($q->merma / 100);
                            break;
                    }
                }

                $arrayProductos[] = [$girasol['Nombre'], $girasol['Neto'], $girasol['NetoFinal']];
                $arrayProductos[] = [$maiz['Nombre'], $maiz['Neto'], $maiz['NetoFinal']];
                $arrayProductos[] = [$soja['Nombre'], $soja['Neto'], $soja['NetoFinal']];
                $arrayProductos[] = [$sorgo['Nombre'], $sorgo['Neto'], $sorgo['NetoFinal']];
                $arrayProductos[] = [$trigo['Nombre'], $trigo['Neto'], $trigo['NetoFinal']];
            }
        } else {
            alert()->warning("La fecha desde debe ser menor a la fecha hasta", 'Ha ocurrido un error')->persistent('Cerrar');
            return back()->withInput();
        }
        if ($control == 0 && $fechaDesde == NULL)
            $control = 2; //No se realizo una busqueda
        return view('reporte.products', compact(['fechaDesde', 'fechaHasta', 'control']))->with('productos', json_encode($arrayProductos));
    }

    public function productivity(Request $request)
    {
        $control = 0;
        $entregadorAutenticado = auth()->user()->idUser;
        $arrayProductividad[] = ['Meses', 'Cantidad de Romaneos'];
        /**Selecciona todos los años sin repetir */
        $aniosSelect = DB::table('aviso_entregador')
            ->join('aviso', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
            ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
            ->where('aviso.estado', '=', 1)
            ->select(DB::raw('YEAR(fecha) as anio'))
            ->distinct()
            ->get();
        $anioQuery = NULL;
        if (isset($request->anio)) {
            $control = 1;
            $anioQuery = $request->anio;
            /**Devuelve la cantidad avisos/romaneos realizados por mes en el año seleccionado */
            $query = DB::table('aviso_entregador')
                ->join('aviso', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
                ->where('aviso.estado', '=', 1)
                ->whereYear('aviso_entregador.fecha', $anioQuery)
                ->select(DB::raw('MONTH(fecha) as mes'), DB::raw('count(*) as cantidad'))
                ->groupBy('mes')
                ->get();
            
            $stop_mes = 12;
            if($anioQuery == date('Y')){
                $stop_mes = date('m');
            }
            for($i_mes = 1; $i_mes < $stop_mes+1; $i_mes++){
                $cant_aux = 0;
                foreach ($query as $q){
                    if($q->mes == $i_mes){
                        $cant_aux = $q->cantidad;
                    }
                }
                switch ($i_mes) {
                    case 1:
                        $arrayProductividad[] = ['Enero', $cant_aux];
                        break;
                    case 2:
                        $arrayProductividad[] = ['Febrero', $cant_aux];
                        break;
                    case 3:
                        $arrayProductividad[] = ['Marzo', $cant_aux];
                        break;
                    case 4:
                        $arrayProductividad[] = ['Abril', $cant_aux];
                        break;
                    case 5:
                        $arrayProductividad[] = ['Mayo', $cant_aux];
                        break;
                    case 6:
                        $arrayProductividad[] = ['Junio', $cant_aux];
                        break;
                    case 7:
                        $arrayProductividad[] = ['Julio', $cant_aux];
                        break;
                    case 8:
                        $arrayProductividad[] = ['Agosto', $cant_aux];
                        break;
                    case 9:
                        $arrayProductividad[] = ['Septiembre', $cant_aux];
                        break;
                    case 10:
                        $arrayProductividad[] = ['Octubre', $cant_aux];
                        break;
                    case 11:
                        $arrayProductividad[] = ['Noviembre', $cant_aux];
                        break;
                    case 12:
                        $arrayProductividad[] = ['Diciembre', $cant_aux];
                        break;
                }
            }
        }

        return view('reporte.productivity', compact(['aniosSelect', 'control']))->with('productividad', json_encode($arrayProductividad));
    }
}
