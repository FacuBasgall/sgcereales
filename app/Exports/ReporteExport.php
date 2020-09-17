<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Aviso;
use App\Carga;
use App\Descarga;
use App\Corredor;
use App\Destino;
use App\Intermediario;
use App\Producto;
use App\Remitente_Comercial;
use App\Titular;
use App\Merma;
use App\User;
use App\Aviso_Entregador;
use App\Aviso_Producto;
use App\Entregador_Contacto;
use App\Entregador_Domicilio;
use App\Localidad;
use App\Provincia;

class ReporteExport implements FromView, ShouldAutoSize
{
    protected $filtros;
    protected $resultados;

    public function __construct($filtros, $resultados)
    {
        $this->filtros = $filtros;
        $this->resultados = $resultados;
    }

    public function view(): View
    {
        $entregadorAutenticado = auth()->user()->idUser;
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

        return view('exports.reporte', compact(['cargas', 'descargas', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'entregador', 'productos', 'avisos_productos',
            'avisos_entregadores', 'localidades', 'provincias', 'resultados', 'filtros']));
    }
}
