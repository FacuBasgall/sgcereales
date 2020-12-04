<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Merma;
use DB;
use Exception;
use SweetAlert;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('entregador');
    }

    public function index(Request $request)
    {
        $query = $request->search;
        if($request->search == ''){
            $productos = Producto::where('borrado', false)->orderBy('nombre')->get();
        }else{
            $producto =  Producto::where('nombre', 'LIKE', "%$query%")->where('borrado', false)->exists();
            if($producto){
                $productos = Producto::where('borrado', false)->where('nombre', 'LIKE', "%$query%")->orderBy('nombre')->get();
            }else{
                $productos = Producto::where('borrado', false)->orderBy('nombre')->get();
                alert()->warning("No se encontraron resultados para: $query", 'No se encontraron resultados')->persistent('Cerrar');
            }
        }
        return view('producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($idProducto)
    {
        $producto = Producto::where('idProducto', $idProducto)->first();
        $mermas = Merma::where('idProducto', $idProducto)->get();
        return view('producto.show', compact(['producto', 'mermas']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($idProducto)
    {
        //
    }
}
