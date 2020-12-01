<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReporteExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\RomaneoSendMail;

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
/*
    public function send_email($idAviso)
    {
        $aviso = Aviso::where('idAviso', $idAviso)->first();
        $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();
        $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
        $remitente = Remitente_Comercial::where('cuit', $aviso->idRemitenteComercial)->first();

        if($aviso->estado){
            $existeTitular = Titular_Contacto::where('cuit', $aviso->idTitularCartaPorte)->where('tipo', 3)->exists();
            $existeCorredor = Corredor_Contacto::where('cuit', $aviso->idCorredor)->where('tipo', 3)->exists();
            $existeRemitente = Remitente_Contacto::where('cuit', $aviso->idRemitenteComercial)->where('tipo', 3)->exists();
            if(!$existeTitular){
                alert()->error("El titular: $titular->nombre no posee dirección de correo", 'No se puede ejecutar la acción')->persistent('Cerrar');
            }elseif(!$existeCorredor){
                alert()->error("El corredor: $corredor->nombre no posee dirección de correo", 'No se puede ejecutar la acción')->persistent('Cerrar');
            }elseif(!$existeRemitente){
                alert()->error("El remitente: $remitente->nombre no posee dirección de correo", 'No se puede ejecutar la acción')->persistent('Cerrar');
            }else{
                $correosTitular = Titular_Contacto::where('cuit', $aviso->idTitularCartaPorte)->where('tipo', 3)->pluck('contacto'); //Tipo = 3 = Emails / funcion pluck('contacto') solo selecciona del array los contactos
                $correosRemitente = Remitente_Contacto::where('cuit', $aviso->idRemitenteComercial)->where('tipo', 3)->pluck('contacto');
                //$correosCorredor se agregar en el RomaneoSendMail
                \Mail::to($correosTitular)->cc($correosRemitente)->send(new RomaneoSendMail($idAviso));
                alert()->success("El aviso ha sido enviado con éxito", 'Correo enviado');
            }
        }else{
            alert()->error("El aviso debe estar terminado para poder enviarlo", 'No se puede ejecutar la acción')->persistent('Cerrar');
        }
        return back();
    } */
}
