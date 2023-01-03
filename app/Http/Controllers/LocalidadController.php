<?php

namespace App\Http\Controllers;

use App\Localidad;
use Illuminate\Http\Request;
use DB;
use App\Provincia;

class LocalidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('entregador');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $localidades = DB::table('localidad')
            ->join('provincia', 'localidad.idProvincia', 'provincia.id')
            ->distinct()
            ->select('localidad.nombre as nombreLocalidad', 'provincia.nombre as nombreProvincia')
            ->orderBy('nombreProvincia')
            ->orderBy('nombreLocalidad')
            ->get();

        return view('localidad.index', compact([
            'localidades',
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincias = DB::table('provincia')
        ->distinct()
        ->select('provincia.*')
        ->orderBy('nombre')
        ->get();

        return view('localidad.create', compact([
            'provincias',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombrelocalidad = $request->localidad;
        $idprovincia = $request->provincia;
        $existe = Localidad::where('idProvincia', $idprovincia)->where('nombre', $nombrelocalidad)->exists();
        if($existe){
            alert()->error("La localidad ya existe en la base de datos", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Localidad;
            $nuevo->idProvincia = $idprovincia;
            $nuevo->nombre = $nombrelocalidad;
            $nuevo->save();
            alert()->success("La localidad fue agregada con éxito", 'Localidad agregada');
            return back();
        }
    }
}
