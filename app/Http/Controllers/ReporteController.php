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
    }

    public function index(Request $request)
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
        foreach($reportesBD as $report){
            $report->delete(); //vaciar la tabla reportes-temp
        }

        $filtrosBD = Filtro::all();
        foreach($filtrosBD as $filt){
            $filt->delete(); //vaciar la tabla filtro-reporte-temp
        }

        if(isset($request->fechaDesde) && isset($request->fechaHasta)){
            if($request->fechaDesde <= $request->fechaHasta){
                $existe = Aviso_Entregador::whereBetween('fecha', [$request->fechaDesde, $request->fechaHasta])->where('idEntregador', $idEntregador)->exists();
                if($existe){
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
            }else{
                alert()->warning("La fecha desde debe ser menor a la fecha hasta", 'Ha ocurrido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }
        if($control){
            if(isset($request->titular)){
                $resultado = $resultado->where('idTitularCartaPorte', $request->titular);
            }
            if(isset($request->corredor)){
                $resultado = $resultado->where('idCorredor', $request->corredor);
            }
            if(isset($request->intermediario)){
                $resultado = $resultado->where('idIntermediario', $request->intermediario);
            }
            if(isset($request->remitente)){
                $resultado = $resultado->where('idRemitenteComercial', $request->remitente);
            }
            if(isset($request->destinatario)){
                $resultado = $resultado->where('idDestinatario', $request->destinatario);
            }
            if(isset($request->entregador)){
                $resultado = $resultado->where('entregador', $request->entregador);
            }
            if(isset($request->producto)){
                $resultado = $resultado->where('idProducto', $request->producto);
            }
            foreach($resultado as $result){
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

        return view('reporte.index', compact(['cargas', 'descargas', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'entregador', 'productos', 'avisos_productos',
            'avisos_entregadores', 'localidades', 'provincias', 'resultado', 'filtros']));
    }

    public function export_excel()
    {
        $hoy = date("Y-m-d");
        $filename = "Reporte General de Descargas " . $hoy . ".xlsx";
        $filtro = Filtro::first();
        return Excel::download(new ReporteExport($filtro->idFiltro), $filename);
    }

    public function export_pdf()
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
                    ->join('carga', 'carga.idCarga', 'descarga.idCarga')
                    ->join('reporte-temp', 'reporte-temp.idAviso', 'carga.idAviso')
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

        $pdf = PDF::loadView('exports.reporte-pdf', compact(['resultados', 'descargas', 'filtros', 'destinatarios', 'titulares',
        'intermediarios', 'remitentes', 'corredores', 'productos', 'entregador', 'localidades', 'provincias',
        'entregador_contacto', 'entregador_domicilio']));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download($filename);

    }

    public function send_email(Request $request)
    {
        $correos = array();
        foreach($request->email as $email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $correos[] = $email;
            }
        }
        $asunto = $request->asunto;
        $cuerpo = $request->cuerpo;
        \Mail::to($correos)->send(new ReporteSendMail($asunto, $cuerpo));
        alert()->success("El reporte general ha sido enviado con éxito", 'Correo enviado');
        return redirect()->action('ReporteController@index');
    }

    public function load_email()
    {
        /**CARGA DE TODOS LOS CORREOS DE TODAS LAS PERSONAS */
        $correosTitular = DB::table('reporte-temp')
                        ->rightJoin('aviso', 'aviso.idAviso', 'reporte-temp.idAviso')
                        ->rightJoin('titular_contacto', 'titular_contacto.cuit', 'aviso.idTitularCartaPorte')
                        ->where('titular_contacto.tipo', '=', 3)
                        ->distinct()
                        ->select('titular_contacto.contacto')
                        ->get();
        $correosCorredor = DB::table('reporte-temp')
                        ->rightJoin('aviso', 'aviso.idAviso', 'reporte-temp.idAviso')
                        ->rightJoin('corredor_contacto', 'corredor_contacto.cuit', 'aviso.idCorredor')
                        ->where('corredor_contacto.tipo', '=', 3)
                        ->distinct()
                        ->select('corredor_contacto.contacto')
                        ->get();
        $correosRemitente = DB::table('reporte-temp')
                        ->rightJoin('aviso', 'aviso.idAviso', 'reporte-temp.idAviso')
                        ->rightJoin('remitente_contacto', 'remitente_contacto.cuit', 'aviso.idRemitenteComercial')
                        ->where('remitente_contacto.tipo', '=', 3)
                        ->distinct()
                        ->select('remitente_contacto.contacto')
                        ->get();
        $correosIntermediario = DB::table('reporte-temp')
                        ->rightJoin('aviso', 'aviso.idAviso', 'reporte-temp.idAviso')
                        ->rightJoin('intermediario_contacto', 'intermediario_contacto.cuit', 'aviso.idIntermediario')
                        ->where('intermediario_contacto.tipo', '=', 3)
                        ->distinct()
                        ->select('intermediario_contacto.contacto')
                        ->get();
        $correosDestinatario = DB::table('reporte-temp')
                        ->rightJoin('aviso', 'aviso.idAviso', 'reporte-temp.idAviso')
                        ->rightJoin('destinatario_contacto', 'destinatario_contacto.cuit', 'aviso.idDestinatario')
                        ->where('destinatario_contacto.tipo', '=', 3)
                        ->distinct()
                        ->select('destinatario_contacto.contacto')
                        ->get();

        /**COPIA AL ARRAY */
        $correos = array();
        foreach($correosTitular as $titular){
            $correos[] = $titular->contacto;
        }
        foreach($correosRemitente as $remitente){
            $correos[] = $remitente->contacto;
        }
        foreach($correosCorredor as $corredor){
            $correos[] = $corredor->contacto;
        }
        foreach($correosIntermediario as $intermediario){
            $correos[] = $intermediario->contacto;
        }
        foreach($correosDestinatario as $destinatario){
            $correos[] = $destinatario->contacto;
        }

        /**ELIMINAR LOS CORREOS REPETIDOS */
        $correos = array_unique($correos);
        $entregadorAutenticado = auth()->user()->idUser;
        $user_preferencias = Usuario_Preferencias_Correo::where('idUser', $entregadorAutenticado)->first();
        $user_email = Entregador_Contacto::where('id', $user_preferencias->email)->first();

        return view('reporte.mail', compact(['correos', 'user_email']));
    }
}
