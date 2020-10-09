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

class AvisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $entregadorAutenticado = auth()->user()->idUser;
        $avisos = Aviso::where('borrado', false)->get();
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinatarios = Destino::where('borrado', false)->get();
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $productos = Producto::where('borrado', false)->get();
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::where('idEntregador', $entregadorAutenticado)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('aviso.index', compact(['avisos', 'cargas', 'descargas', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'productos', 'avisos_productos',
            'avisos_entregadores', 'localidades', 'provincias']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lugarDescargaDB = DB::table('aviso')
                        ->distinct()
                        ->select('aviso.lugarDescarga')
                        ->get();
        $lugarDescarga = array();
        foreach($lugarDescargaDB as $lugar){
            $lugarDescarga[] = $lugar;
        }

        $tipoProductoDB = DB::table('aviso_producto')
                        ->distinct()
                        ->select('aviso_producto.tipo')
                        ->get();
        $tipoProducto = array();
        foreach($tipoProductoDB as $tipo){
            $tipoProducto[] = $tipo;
        }

        $titulares = Titular::where('borrado', false)->orderBy('nombre')->get();
        $intermediarios = Intermediario::where('borrado', false)->orderBy('nombre')->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->orderBy('nombre')->get();
        $corredores = Corredor::where('borrado', false)->orderBy('nombre')->get();
        $destinatarios = Destino::where('borrado', false)->orderBy('nombre')->get();
        $productos = Producto::where('borrado', false)->orderBy('nombre')->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('aviso.create', compact(['lugarDescarga', 'tipoProducto', 'titulares', 'intermediarios', 'remitentes', 'corredores',
            'destinatarios', 'productos', 'localidades', 'provincias']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha1 = "20" . $request->cosecha1;
        $fecha2 = "20" . $request->cosecha2;
        $dif = intval($fecha2) - intval($fecha1);

        if($dif != 1){
            alert()->error("Verifique las fechas ingresadas", 'Ha ocurrido un error')->persistent('Cerrar');
            return back()->withInput();
        }

        $cosecha = $fecha1 . "/" . $fecha2;

        $idEntregador = auth()->user()->idUser;

        $aviso = new Aviso;
        $keyAviso = $this->generate_key($idEntregador);
        $aviso->nroAviso = $keyAviso;
        $aviso->idTitularCartaPorte = $request->titular;
        $aviso->idIntermediario = $request->intermediario;
        $aviso->idRemitenteComercial = $request->remitente;
        $aviso->idCorredor = $request->corredor;
        $aviso->idDestinatario = $request->destinatario;
        $aviso->entregador = $request->entregador;
        $aviso->lugarDescarga = $request->lugarDescarga;
        $aviso->provinciaProcedencia = $request->provincia;
        $aviso->localidadProcedencia = $request->localidad;
        $aviso->idProducto = $request->producto;
        $aviso->observacion = $request->obs;
        $aviso->borrado = false;
        $aviso->estado = false;
        $aviso->save();

        $aviso_producto = new Aviso_Producto;
        $aviso_producto->idAviso = $aviso->idAviso;
        $aviso_producto->idProducto = $request->producto;
        $aviso_producto->cosecha = $cosecha;
        $aviso_producto->tipo = $request->tipo;
        $aviso_producto->save();

        $aviso_entregador = new Aviso_Entregador;
        $aviso_entregador->idAviso = $aviso->idAviso;
        $aviso_entregador->idEntregador = $idEntregador;
        $aviso_entregador->fecha = date("Y-m-d");
        $aviso_entregador->save();

        alert()->success("El aviso fue creado con éxito", 'Aviso creado');
        return redirect()->action('AvisoController@show', $aviso->idAviso);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function show($idAviso)
    {
        $aviso = Aviso::findOrFail($idAviso);
        $cargas = Carga::where('borrado', false)->where('idAviso', $idAviso)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destino = Destino::where('borrado', false)->where('cuit', $aviso->idDestinatario)->first();
        $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();
        $intermediario = Intermediario::where('cuit', $aviso->idIntermediario)->first();
        $remitente = Remitente_Comercial::where('cuit', $aviso->idRemitenteComercial)->first();
        $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso)->get();
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso)->first();
        $entregador = User::where('idUser', $aviso_entregador->idEntregador)->first();
        $localidad = Localidad::where('id', $aviso->localidadProcedencia)->first();
        $provincia = Provincia::where('id', $aviso->provinciaProcedencia)->first();

        $arrayCarga = array();
        $arrayDescarga = array();
        if(!empty($cargas) && $cargas->count()){
            foreach($cargas as $carga){
                $control = false;
                $arrayCarga[] = $carga;
                foreach($descargas as $descarga){
                    if($descarga->idCarga == $carga->idCarga){
                        $control = true;
                        $arrayDescarga[] = $descarga;
                    }
                }
                if($control == false){
                    $descargaVacia = new Descarga;
                    $descargaVacia->idDescarga = "-";
                    $descargaVacia->idCarga = $carga->idCarga;
                    $descargaVacia->fecha = "-";
                    $descargaVacia->bruto = "-";
                    $descargaVacia->tara = "-";
                    $descargaVacia->humedad = "-";
                    $descargaVacia->ph = "-";
                    $descargaVacia->proteina = "-";
                    $descargaVacia->calidad = "-";
                    $descargaVacia->merma = "-";

                    $arrayDescarga[] = $descargaVacia;
                }
            }
        }
        return view('aviso.show', compact(['aviso', 'arrayCarga', 'arrayDescarga', 'destino', 'titular',
            'intermediario', 'remitente', 'corredor', 'producto', 'aviso_producto', 'aviso_entregador',
            'entregador', 'localidad', 'provincia']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function edit($idAviso)
    {
        $lugarDescargaDB = DB::table('aviso')
                        ->distinct()
                        ->select('aviso.lugarDescarga')
                        ->get();
        $lugarDescarga = array();
        foreach($lugarDescargaDB as $lugar){
            $lugarDescarga[] = $lugar;
        }

        $tipoProductoDB = DB::table('aviso_producto')
                        ->distinct()
                        ->select('aviso_producto.tipo')
                        ->get();
        $tipoProducto = array();
        foreach($tipoProductoDB as $tipo){
            $tipoProducto[] = $tipo;
        }

        $aviso = Aviso::findOrFail($idAviso);
        $titulares = Titular::where('borrado', false)->orderBy('nombre')->get();
        $intermediarios = Intermediario::where('borrado', false)->orderBy('nombre')->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->orderBy('nombre')->get();
        $corredores = Corredor::where('borrado', false)->orderBy('nombre')->get();
        $destinatarios = Destino::where('borrado', false)->orderBy('nombre')->get();
        $productos = Producto::where('borrado', false)->orderBy('nombre')->get();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso)->first();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('aviso.edit', compact(['lugarDescarga', 'tipoProducto', 'aviso', 'titulares', 'intermediarios', 'remitentes', 'corredores',
            'destinatarios', 'productos', 'aviso_producto', 'localidades', 'provincias']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idAviso)
    {
        $fecha1 = "20" . $request->cosecha1;
        $fecha2 = "20" . $request->cosecha2;
        $dif = intval($fecha2) - intval($fecha1);

        if($dif != 1){
            alert()->error("Verifique las fechas ingresadas", 'Ha ocurrido un error')->persistent('Cerrar');
            return back();
        }

        $cosecha = $fecha1 . "/" . $fecha2;

        $aviso = Aviso::findOrfail($idAviso);
        $aviso->idTitularCartaPorte = $request->titular;
        $aviso->idIntermediario = $request->intermediario;
        $aviso->idRemitenteComercial = $request->remitente;
        $aviso->idCorredor = $request->corredor;
        $aviso->idDestinatario = $request->destinatario;
        $aviso->lugarDescarga = $request->lugarDescarga;
        $aviso->provinciaProcedencia = $request->provincia;
        $aviso->localidadProcedencia = $request->localidad;
        $aviso->idProducto = $request->producto;
        $aviso->observacion = $request->obs;
        $aviso->save();

        $aviso_producto = Aviso_Producto::findOrfail($idAviso);
        $aviso_producto->idProducto = $request->producto;
        $aviso_producto->cosecha = $cosecha;
        $aviso_producto->tipo = $request->tipo;
        $aviso_producto->save();

        alert()->success("El aviso fue editado con éxito", 'Aviso guardado');
        return redirect()->action('AvisoController@show', $aviso->idAviso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAviso)
    {
        $aviso = Aviso::findOrFail($idAviso);
        $cargas = Carga::where('idAviso', $idAviso)->get();
        foreach ($cargas as $carga){
            $descarga = Descarga::where('idCarga', $carga->idCarga)->first();
            if($descarga)
                $descarga->delete();
            $carga->delete();
        }
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso)->first();
        $aviso_entregador->delete();
        $aviso_producto->delete();
        $aviso->delete();
        alert()->success("El aviso fue eliminado con éxito", 'Aviso eliminado');
        return redirect('/aviso');
    }

    public function change_status($idAviso){
        $aviso = Aviso::findOrFail($idAviso);
        if($aviso->estado == false){
            $cargas = Carga::where('idAviso', $idAviso)->get();
            foreach ($cargas as $carga){
                $descarga = Descarga::where('idCarga', $carga->idCarga)->exists();
                if(!$descarga){
                    //DEVOLVER ERROR -> PARA QUE PUEDA ESTAR TERMINADO DEBE TENER TODAS LAS DESCARGAS
                    alert()->error("Se debe completar el aviso para poder cambiar su estado", 'Ha ocurrido un error')->persistent('Cerrar');
                    return back();
                }
            }
            $aviso->estado = true;
        }else{
            $aviso->estado = false;
        }
        $aviso->save();
        alert()->success("El estado del aviso fue cambiado con éxito", 'Estado cambiado');
        return redirect()->action('AvisoController@show', $idAviso);
    }

    private function generate_key($idEntregador){
        $key = "";
        $existe = Aviso_Entregador::where('idEntregador', $idEntregador)->exists();
        if(!$existe){
            $key = "SGC-0000000001";
        }else{
            $ultAviso = Aviso_Entregador::where('idEntregador', $idEntregador)->orderBy('idAviso', 'desc')->first();
            $ultimo = Aviso::where('idAviso', $ultAviso->idAviso)->first();
            $array = explode("-", $ultimo->nroAviso);
            $array[1] = intval($array[1]+1);
            $nro = str_pad($array[1], 10, "0", STR_PAD_LEFT);
            $key = "SGC-" . $nro;
        }
        return $key;
    }

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
            $localidades = Localidad::all();
            $provincias = Provincia::all();

            $filename = $aviso->nroAviso . " " . $titular->nombre . ".pdf";

            $pdf = PDF::loadView('exports.pdf', compact(['aviso', 'cargas', 'descargas', 'corredor',
                'destinatario', 'intermediario', 'producto', 'remitente', 'titular', 'aviso_producto',
                'aviso_entregador', 'entregador', 'entregador_contacto', 'entregador_domicilio',
                'localidades', 'provincias']));
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
                alert()->success("El aviso ha sido enviado con éxito", 'Correo enviado');
            }
        }else{
            alert()->error("El aviso debe estar terminado para poder enviarlo", 'No se puede ejecutar la acción')->persistent('Cerrar');
        }
        return back();
    }

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
