<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReporteExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\ReporteSendMail;

use App\Filtro;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Titular;
use App\Remitente_Comercial;
use App\User;
use App\Entregador_Contacto;
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
        $filtrosBD = Filtro::all();
        foreach ($filtrosBD as $filt) {
            $filt->delete(); //vaciar la tabla filtro-reporte-temp
        }

        $entregadorAutenticado = auth()->user()->idUser;
        $nombreEntregador = auth()->user()->nombre;

        $fechadesde = $request->fechaDesde;
        $fechahasta = $request->fechaHasta;
        $titular = $request->titular;
        $remitente = $request->remitente;
        $corredor = $request->corredor;
        $destinatario = $request->destinatario;
        $producto = $request->producto;
        $entregador = $request->entregador;

        $avisos = NULL;

        if (isset($fechadesde) && isset($fechahasta)) {
            if ($fechadesde <= $fechahasta) {
                $avisos = DB::table('aviso_entregador')
                    ->join('aviso', 'aviso_entregador.idAviso', '=', 'aviso.idAviso')
                    ->join('destinatario', 'aviso.idDestinatario', '=', 'destinatario.cuit')
                    ->join('titular', 'aviso.idTitularCartaPorte', '=', 'titular.cuit')
                    ->join('corredor', 'aviso.idCorredor', '=', 'corredor.cuit')
                    ->join('remitente', 'aviso.idRemitenteComercial', '=', 'remitente.cuit')
                    ->join('producto', 'aviso.idProducto', '=', 'producto.idProducto')
                    ->join('localidad', 'aviso.localidadProcedencia', '=', 'localidad.id')
                    ->join('provincia', 'aviso.provinciaProcedencia', '=', 'provincia.id')
                    ->join('carga', 'aviso.idAviso', 'carga.idAviso')
                    ->join('descarga', 'carga.idCarga', 'descarga.idCarga')
                    ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
                    ->whereBetween('aviso_entregador.fecha', [$fechadesde, $fechahasta])
                    ->where('aviso.estado', '=', true)
                    ->when($titular, function ($avisos, $titular) {
                        return $avisos->where('aviso.idTitularCartaPorte', $titular);
                    })
                    ->when($remitente, function ($avisos, $remitente) {
                        return $avisos->where('aviso.idRemitenteComercial', $remitente);
                    })
                    ->when($corredor, function ($avisos, $corredor) {
                        return $avisos->where('aviso.idCorredor', $corredor);
                    })
                    ->when($destinatario, function ($avisos, $destinatario) {
                        return $avisos->where('aviso.idDestinatario', $destinatario);
                    })
                    ->when($producto, function ($avisos, $producto) {
                        return $avisos->where('aviso.idProducto', $producto);
                    })
                    ->when($entregador, function ($avisos, $entregador) {
                        return $avisos->where('aviso.entregador', $entregador);
                    })
                    ->select(
                        'aviso.idAviso',
                        'aviso.nroAviso',
                        'aviso_entregador.fecha',
                        'producto.nombre as productoNombre',
                        'destinatario.nombre as destinatarioNombre',
                        'titular.nombre as titularNombre',
                        'corredor.nombre as corredorNombre',
                        'remitente.nombre as remitenteNombre',
                        'localidad.nombre as localidadNombre',
                        'provincia.abreviatura as provinciaAbreviatura',
                        'aviso.entregador',
                        'aviso.lugarDescarga',
                        'descarga.bruto',
                        'descarga.tara',
                        'descarga.merma'
                    )
                    ->orderByDesc('aviso_entregador.fecha', 'aviso.nroAviso')
                    ->get();

                $nuevoFiltro = new Filtro;
                $nuevoFiltro->fechaDesde = $fechadesde;
                $nuevoFiltro->fechaHasta = $fechahasta;
                $nuevoFiltro->idTitular = $titular;
                $nuevoFiltro->idRemitente = $remitente;
                $nuevoFiltro->idCorredor = $corredor;
                $nuevoFiltro->idDestinatario = $destinatario;
                $nuevoFiltro->idProducto = $producto;
                $nuevoFiltro->entregador = $entregador;
                $nuevoFiltro->save();
            } else {
                alert()->warning("La fecha desde debe ser menor a la fecha hasta", 'Ha ocurrido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }

        $entregadorDB = DB::table('aviso')
            ->distinct()
            ->select('aviso.entregador')
            ->get();
        $entregadores = array();
        foreach ($entregadorDB as $e) {
            $entregadores[] = $e;
        }
        $destinatarios = Destino::where('borrado', false)->orderBy('nombre')->get();
        $titulares = Titular::where('borrado', false)->orderBy('nombre')->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->orderBy('nombre')->get();
        $corredores = Corredor::where('borrado', false)->orderBy('nombre')->get();
        $productos = Producto::where('borrado', false)->orderBy('nombre')->get();

        return view('reporte.summary', compact([
            'avisos', 'nombreEntregador', 'destinatarios', 'titulares', 'remitentes', 'corredores', 'productos',
            'fechadesde', 'fechahasta', 'titular', 'remitente', 'corredor', 'destinatario', 'producto', 'entregador', 'entregadores',
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
        $filtro = Filtro::first();
        $fechadesde = $filtro->fechaDesde;
        $fechahasta = $filtro->fechaHasta;
        $titular = $filtro->idTitular;
        $remitente = $filtro->idRemitente;
        $corredor = $filtro->idCorredor;
        $destinatario = $filtro->idDestinatario;
        $producto = $filtro->idProducto;
        $entregador = $filtro->entregador;

        $avisos = DB::table('aviso_entregador')
            ->join('aviso', 'aviso_entregador.idAviso', '=', 'aviso.idAviso')
            ->join('destinatario', 'aviso.idDestinatario', '=', 'destinatario.cuit')
            ->join('titular', 'aviso.idTitularCartaPorte', '=', 'titular.cuit')
            ->join('corredor', 'aviso.idCorredor', '=', 'corredor.cuit')
            ->join('remitente', 'aviso.idRemitenteComercial', '=', 'remitente.cuit')
            ->join('producto', 'aviso.idProducto', '=', 'producto.idProducto')
            ->join('localidad', 'aviso.localidadProcedencia', '=', 'localidad.id')
            ->join('provincia', 'aviso.provinciaProcedencia', '=', 'provincia.id')
            ->join('carga', 'aviso.idAviso', 'carga.idAviso')
            ->join('descarga', 'carga.idCarga', 'descarga.idCarga')
            ->join('intermediario', 'aviso.idIntermediario', '=', 'intermediario.cuit')
            ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
            ->whereBetween('aviso_entregador.fecha', [$fechadesde, $fechahasta])
            ->where('aviso.estado', '=', true)
            ->when($titular, function ($avisos, $titular) {
                return $avisos->where('aviso.idTitularCartaPorte', $titular);
            })
            ->when($remitente, function ($avisos, $remitente) {
                return $avisos->where('aviso.idRemitenteComercial', $remitente);
            })
            ->when($corredor, function ($avisos, $corredor) {
                return $avisos->where('aviso.idCorredor', $corredor);
            })
            ->when($destinatario, function ($avisos, $destinatario) {
                return $avisos->where('aviso.idDestinatario', $destinatario);
            })
            ->when($producto, function ($avisos, $producto) {
                return $avisos->where('aviso.idProducto', $producto);
            })
            ->when($entregador, function ($avisos, $entregador) {
                return $avisos->where('aviso.entregador', $entregador);
            })
            ->select(
                'aviso.idAviso',
                'aviso.nroAviso',
                'aviso_entregador.fecha',
                'producto.nombre as productoNombre',
                'destinatario.nombre as destinatarioNombre',
                'titular.nombre as titularNombre',
                'corredor.nombre as corredorNombre',
                'remitente.nombre as remitenteNombre',
                'intermediario.nombre as intermediarioNombre',
                'aviso.entregador',
                'aviso.lugarDescarga',
                'descarga.bruto',
                'descarga.tara',
                'descarga.merma'
            )
            ->orderByDesc('aviso_entregador.fecha', 'aviso.nroAviso')
            ->get();

        $usuario = User::where('idUser', $entregadorAutenticado)->select('nombre', 'descripcion')->first();
        $contactos = Entregador_Contacto::where('idUser', $entregadorAutenticado)->select('contacto')->get();
        $domicilio = DB::table('entregador_domicilio')
            ->join('localidad', 'entregador_domicilio.localidad', 'localidad.id')
            ->join('provincia', 'entregador_domicilio.provincia', 'provincia.id')
            ->where('entregador_domicilio.idUser', '=', $entregadorAutenticado)
            ->where('localidad.id', '=', 'entregador_domicilio.localidad')
            ->where('provincia.id', '=', 'entregador_domicilio.provincia')
            ->select(
                'entregador_domicilio.domicilio as calle',
                'entregador_domicilio.cp',
                'localidad.nombre as nombreLocalidad',
                'provincia.abreviatura as provinciaAbrev'
            )
            ->get();

        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('exports.reporte-pdf', compact([
            'avisos', 'domicilio', 'usuario', 'contactos', 'fechadesde', 'fechahasta',
        ]));
        $pdf->setPaper('oficio', 'landscape');
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
            if ($anioQuery == date('Y')) {
                $stop_mes = date('m');
            }
            for ($i_mes = 1; $i_mes < $stop_mes + 1; $i_mes++) {
                $cant_aux = 0;
                foreach ($query as $q) {
                    if ($q->mes == $i_mes) {
                        $cant_aux = $q->cantidad;
                    }
                }
                switch ($i_mes) {
                    case 1:
                        $arrayProductividad[] = ['Ene', $cant_aux];
                        break;
                    case 2:
                        $arrayProductividad[] = ['Feb', $cant_aux];
                        break;
                    case 3:
                        $arrayProductividad[] = ['Mar', $cant_aux];
                        break;
                    case 4:
                        $arrayProductividad[] = ['Abr', $cant_aux];
                        break;
                    case 5:
                        $arrayProductividad[] = ['May', $cant_aux];
                        break;
                    case 6:
                        $arrayProductividad[] = ['Jun', $cant_aux];
                        break;
                    case 7:
                        $arrayProductividad[] = ['Jul', $cant_aux];
                        break;
                    case 8:
                        $arrayProductividad[] = ['Ago', $cant_aux];
                        break;
                    case 9:
                        $arrayProductividad[] = ['Sep', $cant_aux];
                        break;
                    case 10:
                        $arrayProductividad[] = ['Oct', $cant_aux];
                        break;
                    case 11:
                        $arrayProductividad[] = ['Nov', $cant_aux];
                        break;
                    case 12:
                        $arrayProductividad[] = ['Dic', $cant_aux];
                        break;
                }
            }
        }

        return view('reporte.productivity', compact(['aniosSelect', 'control', 'anioQuery']))->with('productividad', json_encode($arrayProductividad));
    }
}
