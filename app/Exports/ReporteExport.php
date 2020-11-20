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
use App\Filtro;
use App\Reporte;

use DB;

class ReporteExport implements FromView, ShouldAutoSize
{
    protected $idFiltro;

    public function __construct($idFiltro)
    {
        $this->idFiltro = $idFiltro;
    }

    public function view(): View
    {
       /*
        $reporte = Reporte::all();
        $avisos = DB::table('aviso')
                    ->join('reporte-temp', 'aviso.idAviso', '=', 'reporte-temp.idAviso')
                    ->select('aviso.*')
                    ->get();
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        */

        $entregadorAutenticado = auth()->user()->idUser;
        $filtros = Filtro::where('idFiltro', $this->idFiltro)->first();
        $resultados = DB::table('reporte-temp')
                        ->join('aviso', 'reporte-temp.idAviso', '=', 'aviso.idAviso')
                        ->join('carga', 'aviso.idAviso', '=', 'carga.idAviso')
                        ->join('descarga', 'carga.idCarga', '=', 'descarga.idCarga')
                        ->join('aviso_entregador',  'aviso.idAviso', '=', 'aviso_entregador.idAviso')
                        ->join('aviso_producto', 'aviso.idAviso', '=', 'aviso_producto.idAviso')
                        ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
                        ->select('reporte-temp.*', 'aviso.*', 'carga.*', 'descarga.*', 'aviso_producto.*')
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


        return view('exports.reporte', compact(['resultados', 'filtros', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'productos', 'entregador', 'localidades', 'provincias',
            'entregador_contacto', 'entregador_domicilio']));
    }
}
