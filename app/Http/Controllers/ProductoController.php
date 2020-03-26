<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use DB;
use Exception;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayProductos = DB::table('producto')->where('borrado', false)->get();
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
        $nuevo->nombre = $request->input('nombre');
        $nuevo->merma = $request->input('merma');
        $nuevo->save();
        alert()->success("El producto $nuevo->nombre fue creado con exito", 'Creado con exito');
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
        //
    }  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idProducto)
    {
        
        try {
            $producto = Producto::findOrFail($idProducto);
        }catch(MethodNotAllowedHttpException $e){
            alert()->error('Ese producto no fue encontrado','Producto no encontrado')->persistent('Close');
            return redirect('/producto') ;
        }
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
        try { //no funciona el catch
            $nuevo = Producto::findOrFail($idProducto);
        }catch(Exception  $e){
            alert()->error('Error Message', 'Optional Title')->persistent('Close');
            return redirect('/producto') ;
        }
        $nuevo->merma = $request->input('merma');
        $nuevo->save();
        alert()->success("El producto $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect('/producto') ;

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
        $producto->borrado = true;
        $producto->save();
        alert()->success("El producto fue eliminado con exito", 'Eliminado con exito');
        return redirect('/producto');
    }  
}
