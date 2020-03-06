<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayProductos = DB::table('producto')->get();
        return view('producto.index', array('arrayProductos'=>$arrayProductos));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('producto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo = new Producto;
        $nuevo = $request->all();
        $nuevo->save();
        return redirect('/producto');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($idProducto)
    {
        $producto = Producto::findOrFail($idProducto);
        return view('producto.show', array('producto'=>$producto));
    }  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idProducto)
    {
        $producto = Producto::findOrFail($idProducto);
        return view('producto.edit', array('producto'=>$producto));
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
        $nuevo = Producto::findOrFail($idProducto);
        $nuevo->merma = $request->input('merma');
        $nuevo->save();
        return redirect('/producto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($idProducto)
    {
        $producto = Producto::findOrFail($idProducto);
        $producto->delete();
    }  
}
