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

class RomaneoExport implements FromView, ShouldAutoSize
{
    protected $idAviso;

    public function __construct($idAviso)
    {
        $this->idAviso = $idAviso;
        $sheet->setAutoSize(true);
    }

    public function view(): View
    {
        $aviso = Aviso::where('idAviso', $this->idAviso)->first();
        $cargas = Carga::where('idAviso', $aviso->idAviso)->get();
        $descargas = Descarga::all();
        $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
        $destinatario = Destino::where('cuit', $aviso->idDestinatario)->first();
        $intermediario = Intermediario::where('cuit', $aviso->idIntermediario)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $remitente = Remitente_Comercial::where('cuit', $aviso->idRemitenteComercial)->first();
        $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $aviso->idAviso)->first();
        $aviso_entregador = Aviso_Entregador::where('idAviso', $aviso->idAviso)->first();
        $entregador = User::where('idUser', $aviso_entregador->idEntregador)->first();
        $entregador_contacto = Entregador_Contacto::where('idUser', $entregador->idUser)->get();
        $entregador_domicilio = Entregador_Domicilio::where('idUser', $entregador->idUser)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('exports.romaneo', compact(['aviso', 'cargas', 'descargas', 'corredor', 'destinatario',
            'intermediario', 'producto', 'remitente', 'titular', 'aviso_producto', 'aviso_entregador',
            'entregador', 'entregador_contacto', 'entregador_domicilio', 'localidades', 'provincias']));
    }
}
