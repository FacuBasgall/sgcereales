<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RomaneoExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Aviso;
use App\Descarga;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Titular;
use App\Intermediario;
use App\Remitente_Comercial;
use App\User;
use App\Aviso_Producto;
use App\Aviso_Entregador;
use Datatables;
use DB;

class AvisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avisos = Aviso::where('borrado', false)->orderBy('idAviso', 'desc')->get();
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinatarios = Destino::where('borrado', false)->get();
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $productos = Producto::where('borrado', false)->get();
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::all();

        return view('aviso.index', compact(['avisos', 'cargas', 'descargas', 'destinatarios', 'titulares', 'intermediarios', 'remitentes', 'corredores', 'entregadores', 'productos', 'avisos_productos', 'avisos_entregadores']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $destinatarios = Destino::where('borrado', false)->get();
        $productos = Producto::where('borrado', false)->get();

        return view('aviso.create', compact(['titulares', 'intermediarios', 'remitentes', 'corredores', 'entregadores', 'destinatarios', 'productos']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cosecha = "20" . $request->cosecha1 . "/20" . $request->cosecha2;

        $aviso = new Aviso;
        $keyAviso = $this->generate_key();
        $aviso->idAviso = $keyAviso;
        $aviso->idTitularCartaPorte = $request->titular;
        $aviso->idIntermediario = $request->intermediario;
        $aviso->idRemitenteComercial = $request->remitente;
        $aviso->idCorredor = $request->corredor;
        $aviso->idDestinatario = $request->destinatario;
        $aviso->idEntregador = 1;
        $aviso->lugarDescarga = $request->lugarDescarga;
        $aviso->provinciaProcedencia = $request->provincia;
        $aviso->localidadProcedencia = $request->localidad;
        $aviso->idProducto = $request->producto;
        $aviso->borrado = false;
        $aviso->estado = false;
        $aviso->save();

        $aviso_producto = new Aviso_Producto;
        $aviso_producto->idAviso = $keyAviso;
        $aviso_producto->idProducto = $request->producto;
        $aviso_producto->cosecha = $cosecha;
        $aviso_producto->tipo = $request->tipo;
        $aviso_producto->save();

        $aviso_entregador = new Aviso_Entregador;
        $aviso_entregador->idAviso = $keyAviso;
        $aviso_entregador->idEntregador = 1;
        $aviso_entregador->fecha = date("Y-m-d");
        $aviso_entregador->save();

        return redirect()->action('CargaController@create', $keyAviso);
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
        $entregador = User::where('idUser', $aviso->idEntregador)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso)->get();
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso)->get();

        return view('aviso.show', compact(['aviso', 'cargas', 'descargas', 'destino', 'titular', 'intermediario', 'remitente', 'corredor', 'entregador', 'producto', 'aviso_producto', 'aviso_entregador']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function edit($idAviso)
    {
        $aviso = Aviso::findOrFail($idAviso);
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $destinatarios = Destino::where('borrado', false)->get();
        $productos = Producto::where('borrado', false)->get();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso)->first();

        return view('aviso.edit', compact(['aviso', 'titulares', 'intermediarios', 'remitentes', 'corredores', 'entregadores', 'destinatarios', 'productos', 'aviso_producto']));
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
        if($request->estado == "Terminado")
            $aviso->estado = true;
        else $aviso->estado = false;
        $aviso->save();

        $aviso_producto = Aviso_Producto::findOrfail($idAviso);
        $aviso_producto->idProducto = $request->producto;
        $aviso_producto->cosecha = $request->cosecha;
        $aviso_producto->tipo = $request->tipo;
        $aviso_producto->save();

        $existeCarga = Carga::where('idAviso', $idAviso)->exists();
        if($existeCarga){
            return redirect()->action('CargaController@edit', $aviso->idAviso);
        }else{
            return redirect()->action('AvisoController@show', $aviso->idAviso);
        }

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
        alert()->success("El aviso fue eliminado con exito", 'Eliminado con exito');
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
                    alert()->error("Se debe completar el aviso para poder cambiar su estado", 'Ha ocurrido un error');
                    return back();
                }
            }
            $aviso->estado = true;
        }else{
            $aviso->estado = false;
        }
        $aviso->save();
        alert()->success("El estado del aviso fue cambiado con exito", 'Estado cambiado');
        return back();
    }

    private function generate_key(){
        $key = "";
        $existe = Aviso::all();
        if($existe->isEmpty()){
            $key = "SGC-0000000001";
        }else{
            $ultimo = Aviso::orderBy('idAviso', 'desc')->first();
            $array = explode("-", $ultimo->idAviso);
            $array[1] = intval($array[1]+1);
            $nro = str_pad($array[1], 10, "0", STR_PAD_LEFT);
            $key = "SGC-" . $nro;
        }
        return $key;
    }

    public function export()
    {
        return Excel::download(new RomaneoExport, 'romaneo.xlsx');
    }
}
