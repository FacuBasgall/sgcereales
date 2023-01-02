<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Corredor;
use App\Destino;
use App\Intermediario;
use App\Producto;
use App\Remitente_Comercial;
use App\Titular;
use App\Entregador_Contacto;
use App\Filtro;
use App\Localidad;
use App\Provincia;
use App\Entregador_Domicilio;
use App\User;

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
        $filtro = Filtro::where('idFiltro', $this->idFiltro)->first();
        $fechadesde = $filtro->fechaDesde;
        $fechahasta = $filtro->fechaHasta;
        $titular = $filtro->idTitular;
        $remitente = $filtro->idRemitente;
        $corredor = $filtro->idCorredor;
        $destinatario = $filtro->idDestinatario;
        $producto = $filtro->idProducto;

        $avisos = DB::table('aviso')
            ->join('aviso_entregador', 'aviso.idAviso', '=', 'aviso_entregador.idAviso')
            ->join('aviso_producto', 'aviso.idAviso', '=', 'aviso_producto.idAviso')
            ->join('destinatario', 'aviso.idDestinatario', '=', 'destinatario.cuit')
            ->join('titular', 'aviso.idTitularCartaPorte', '=', 'titular.cuit')
            ->join('corredor', 'aviso.idCorredor', '=', 'corredor.cuit')
            ->join('remitente', 'aviso.idRemitenteComercial', '=', 'remitente.cuit')
            ->join('intermediario', 'aviso.idIntermediario', '=', 'intermediario.cuit')
            ->join('producto', 'aviso.idProducto', '=', 'producto.idProducto')
            ->join('localidad', 'aviso.localidadProcedencia', '=', 'localidad.id')
            ->join('provincia', 'aviso.provinciaProcedencia', '=', 'provincia.id')
            ->join('carga', 'aviso.idAviso', 'carga.idAviso')
            ->join('descarga', 'carga.idCarga', 'descarga.idCarga')
            ->where('aviso_entregador.idEntregador', '=', $entregadorAutenticado)
            ->whereBetween('aviso_entregador.fecha', [$fechadesde, $fechahasta])
            ->where('aviso.estado', '=', true)
            ->when($titular, function ($avisos, $titular) {
                return $avisos->where('aviso.idTitularCartaPorte', $titular);
            })
            ->when($remitente, function ($avisos, $remitente) {
                return $avisos->where('aviso.idRemitenteComercial', $remitente);
            })
            ->when($corredor, function ($avisos, $corredor) {
                return $avisos->where('aviso.idCorredor', $corredor);
            })
            ->when($destinatario, function ($avisos, $destinatario) {
                return $avisos->where('aviso.idDestinatario', $destinatario);
            })
            ->when($producto, function ($avisos, $producto) {
                return $avisos->where('aviso.idProducto', $producto);
            })
            ->select(
                'aviso.idAviso',
                'aviso.nroAviso',
                'aviso_entregador.fecha',
                'producto.nombre as productoNombre',
                'aviso_producto.tipo as tipoProducto',
                'destinatario.nombre as destinatarioNombre',
                'titular.nombre as titularNombre',
                'corredor.nombre as corredorNombre',
                'remitente.nombre as remitenteNombre',
                'intermediario.nombre as intermediarioNombre',
                'localidad.nombre as localidadNombre',
                'provincia.abreviatura as provinciaAbreviatura',
                'aviso.entregador',
                'aviso.lugarDescarga',
                'descarga.bruto',
                'descarga.tara',
                'descarga.merma'
            )
            ->orderByDesc('aviso_entregador.fecha', 'aviso.nroAviso')
            ->get();

        $entregador = User::where('idUser', $entregadorAutenticado)->select('nombre', 'descripcion')->first();
        $contactos = Entregador_Contacto::where('idUser', $entregadorAutenticado)->select('contacto')->get();
        $domicilio = DB::table('entregador_domicilio')
            ->join('localidad', 'entregador_domicilio.localidad', 'localidad.id')
            ->join('provincia', 'entregador_domicilio.provincia', 'provincia.id')
            ->where('entregador_domicilio.idUser', '=', $entregadorAutenticado)
            ->where('localidad.id', '=', 'entregador_domicilio.localidad')
            ->where('provincia.id', '=', 'entregador_domicilio.provincia')
            ->select(
                'entregador_domicilio.domicilio as calle',
                'entregador_domicilio.cp',
                'localidad.nombre as nombreLocalidad',
                'provincia.abreviatura as provinciaAbrev'
            )
            ->get();

        return view('exports.reporte', compact([
            'avisos', 'domicilio', 'entregador', 'contactos', 'fechadesde', 'fechahasta',
        ]));
    }
}
