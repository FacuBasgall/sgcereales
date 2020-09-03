<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RomaneoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App\Mail\RomaneoSendMail;

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
use MultiMail;
use SweetAlert;

class ReporteController extends Controller
{
    public function index(){
        $destinatarios = Destino::where('borrado', false)->get();
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $productos = Producto::where('borrado', false)->get();

        return view('reporte.index', compact(['destinatarios', 'titulares', 'intermediarios',
            'remitentes', 'corredores', 'productos']));
    }

    public function find(Request $request){
        $resultado;
        $filtros = array(
            "fechaDesde" => "",
            "fechaHasta" => "",
            "titular" => "",
            "intermediario" => "",
            "remitente" => "",
            "corredor" => "",
            "destinatario" => "",
            "entregador" => "",
            "producto" => "",
        );
        if(isset($request->fechaDesde) && isset($request->fechaHasta)){
            $filtros["fechaDesde"] = $request->fechaDesde;
            $filtros["fechaHasta"] = $request->fechaHasta;
            if($request->fechaDesde < $request->fechaHasta){
                $existe = Aviso_Entregador::whereBetween('fecha', [$request->fechaDesde, $request->fechaHasta])->where('idEntregador', 1)->exists();
                if($existe){
                    $resultado = DB::table('aviso')
                                ->join('aviso_entregador', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                                ->whereBetween('aviso_entregador.fecha', [$request->fechaDesde, $request->fechaHasta])
                                ->where('aviso_entregador.idEntregador', '=', 1)
                                ->select('aviso.*')
                                ->get();
                }else{
                    alert()->warning("No existen avisos en las fechas seleccionadas", 'No se encontraron resultados')->persistent('Cerrar');
                    return back()->withInput();
                }
            }else{
                alert()->error("La fecha desde debe ser menor a la fecha hasta", 'Ha ocurrido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }elseif(isset($request->fechaDesde)){
            $filtros["fechaDesde"] = $request->fechaDesde;
            $existe = Aviso_Entregador::where('fecha', '>', $request->fechaDesde)->where('idEntregador', 1)->exists();
            if($existe){
                $resultado = DB::table('aviso')
                            ->join('aviso_entregador', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                            ->where('aviso_entregador.fecha', '>', $request->fechaDesde)
                            ->where('aviso_entregador.idEntregador', '=', 1)
                            ->select('aviso.*')
                            ->get();
            }else{
                alert()->warning("No existen avisos en la fecha seleccionada", 'No se encontraron resultados')->persistent('Cerrar');
                return back()->withInput();
            }
        }elseif(isset($request->fechaHasta)){
            $filtros["fechaHasta"] = $request->fechaHasta;
            $existe = Aviso_Entregador::where('fecha', '<', $request->fechaHasta)->where('idEntregador', 1)->exists();
            if($existe){
                $resultado = DB::table('aviso')
                            ->join('aviso_entregador', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                            ->where('aviso_entregador.fecha', '<', $request->fechaHasta)
                            ->where('aviso_entregador.idEntregador', '=', 1)
                            ->select('aviso.*')
                            ->get();
            }else{
                alert()->warning("No existen avisos en la fecha seleccionada", 'Ha ocurrido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }else{
            $resultado = DB::table('aviso')
                        ->join('aviso_entregador', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                        ->where('aviso_entregador.idEntregador', '=', 1)
                        ->select('aviso.*')
                        ->get();
        }
        if(isset($request->titular)){
            $filtros["titular"] = $request->titular;
            $resultado = $resultado->where('idTitularCartaPorte', $request->titular);
        }
        if(isset($request->corredor)){
            $filtros["corredor"] = $request->corredor;
            $resultado = $resultado->where('idCorredor', $request->corredor);
        }
        if(isset($request->intermediario)){
            $filtros["intermediario"] = $request->intermediario;
            $resultado = $resultado->where('idIntermediario', $request->intermediario);
        }
        if(isset($request->remitente)){
            $filtros["remitente"] = $request->remitente;
            $resultado = $resultado->where('idRemitenteComercial', $request->remitente);
        }
        if(isset($request->destinatario)){
            $filtros["destinatario"] = $request->destinatario;
            $resultado = $resultado->where('idDestinatario', $request->destinatario);
        }
        if(isset($request->entregador)){
            $filtros["entregador"] = $request->entregador;
            $resultado = $resultado->where('idEntregador', $request->entregador);
        }
        if(isset($request->producto)){
            $filtros["producto"] = $request->producto;
            $resultado = $resultado->where('idProducto', $request->producto);
        }

        $entregadorAutenticado = 1;
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinatarios = Destino::where('borrado', false)->get();
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregador = User::where('idUser', $entregadorAutenticado)->first(); //Solo Usuario Entregador Autenticado
        $productos = Producto::where('borrado', false)->get();
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::where('idEntregador', $entregadorAutenticado)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('reporte.result', compact(['cargas', 'descargas', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'entregador', 'productos', 'avisos_productos',
            'avisos_entregadores', 'localidades', 'provincias', 'resultado', 'filtros']));
    }
/*
    public function export_excel($idAviso)
    {
        $aviso = Aviso::where('idAviso', $idAviso)->first();

        if($aviso->estado){
            $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();
            $filename = $aviso->nroAviso . " " . $titular->nombre . ".xlsx";
            return Excel::download(new RomaneoExport($idAviso), $filename);
        }else{
            alert()->error("El aviso debe estar terminado para exportalo", 'No se puede ejecutar la acción')->persistent('Cerrar');
            return back();
        }

    }

    public function export_pdf($idAviso)
    {
        $aviso = Aviso::where('idAviso', $idAviso)->first();

        if($aviso->estado){
            $cargas = Carga::where('idAviso', $aviso->idAviso)->get();
            $descargas = Descarga::all();
            $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
            $destinatario = Destino::where('cuit', $aviso->idDestinatario)->first();
            $intermediario = Intermediario::where('cuit', $aviso->idIntermediario)->first();
            $producto = Producto::where('idProducto', $aviso->idProducto)->first();
            $remitente = Remitente_Comercial::where('cuit', $aviso->idRemitenteComercial)->first();
            $aviso_producto = Aviso_Producto::where('idAviso', $aviso->idAviso)->first();
            $aviso_entregador = Aviso_Entregador::where('idAviso', $aviso->idAviso)->first();
            $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();
            $entregador = User::where('idUser', $aviso_entregador->idEntregador)->first();
            $entregador_contacto = Entregador_Contacto::where('idUser', $entregador->idUser)->get();
            $entregador_domicilio = Entregador_Domicilio::where('idUser', $entregador->idUser)->get();
            $localidad = Localidad::where('id', $aviso->localidadProcedencia)->first();
            $provincia = Provincia::where('id', $aviso->provinciaProcedencia)->first();

            $filename = $aviso->nroAviso . " " . $titular->nombre . ".pdf";

            $pdf = PDF::loadView('exports.pdf', compact(['aviso', 'cargas', 'descargas', 'corredor',
                'destinatario', 'intermediario', 'producto', 'remitente', 'titular', 'aviso_producto',
                'aviso_entregador', 'entregador', 'entregador_contacto', 'entregador_domicilio',
                'localidad', 'provincia']));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($filename);
        }else{
            alert()->error("El aviso debe estar terminado para exportalo", 'No se puede ejecutar la acción')->persistent('Cerrar');
            return back();
        }
    }

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
                \MultiMail::to($correosTitular)->cc($correosRemitente)->send(new RomaneoSendMail($idAviso));
                alert()->success("El aviso ha sido enviado con exito", 'Correo enviado');
            }
        }else{
            alert()->error("El aviso debe estar terminado para poder enviarlo", 'No se puede ejecutar la acción')->persistent('Cerrar');
        }
        return back();
    } */

    public function getLocalidades(Request $request)
    {
        if($request->ajax()){
            $localidades = Localidad::where('idProvincia', $request->provincia_id)->get();
            foreach($localidades as $localidad){
                $localidadesArray[$localidad->id] = $localidad->nombre;
            }
            return response()->json($localidadesArray);
        }
    }
}
