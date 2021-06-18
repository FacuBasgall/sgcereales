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
        $entregadorAutenticado = auth()->user()->idUser;
        $filtros = Filtro::where('idFiltro', $this->idFiltro)->first();
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
        $titulares = Titular::all();
        $destinatarios = Destino::all();
        $intermediarios = Intermediario::all();
        $remitentes = Remitente_Comercial::all();
        $corredores = Corredor::all();
        $productos = Producto::where('borrado', false)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();
        $entregador = User::where('idUser', $entregadorAutenticado)->first();
        $entregador_contacto = Entregador_Contacto::where('idUser', $entregadorAutenticado)->get();
        $entregador_domicilio = Entregador_Domicilio::where('idUser', $entregadorAutenticado)->get();

        return view('exports.reporte', compact(['resultados', 'descargas', 'filtros', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'productos', 'localidades', 'provincias', 'entregador',
            'entregador_contacto', 'entregador_domicilio']));
    }
}
