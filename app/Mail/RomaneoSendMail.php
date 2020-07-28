<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Exports\RomaneoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

use App\Aviso;
use App\Descarga;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Titular;
use App\Titular_Contacto;
use App\Intermediario;
use App\Remitente_Comercial;
use App\User;
use App\Aviso_Producto;
use App\Aviso_Entregador;
use App\Entregador_Contacto;
use App\Entregador_Domicilio;

class RomaneoSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $nroAviso;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nroAviso)
    {
        $this->nroAviso = $nroAviso;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $aviso = Aviso::where('idAviso', $this->nroAviso)->first();
        $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();

        $cargas = Carga::where('idAviso', $aviso->idAviso)->get();
        $descargas = Descarga::all();
        $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
        $destinatario = Destino::where('cuit', $aviso->idDestinatario)->first();
        $intermediario = Intermediario::where('cuit', $aviso->idIntermediario)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $remitente = Remitente_Comercial::where('cuit', $aviso->idRemitenteComercial)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $aviso->idAviso)->first();
        $aviso_entregador = Aviso_Entregador::where('idAviso', $aviso->idAviso)->first();
        $titular = Titular::where('cuit', $aviso->idTitularCartaPorte)->first();
        $entregador = User::where('idUser', $aviso_entregador->idEntregador)->first();
        $entregador_contacto = Entregador_Contacto::where('idUser', $entregador->idUser)->get();
        $entregador_domicilio = Entregador_Domicilio::where('idUser', $entregador->idUser)->get();

        $pdf = PDF::loadView('exports.pdf', compact(['aviso', 'cargas', 'descargas', 'corredor', 'destinatario', 'intermediario', 'producto', 'remitente', 'titular', 'aviso_producto', 'aviso_entregador', 'entregador', 'entregador_contacto', 'entregador_domicilio']));
        $pdf->setPaper('a4', 'landscape');

        $filenameExcel = $this->nroAviso . " " . $titular->nombre . ".xlsx";
        $filenamePdf = $this->nroAviso . " " . $titular->nombre . ".pdf";
        $asunto = "Envio del aviso nro: " . $this->nroAviso;

        return $this->view('mails.romaneo_mail')
            ->subject($asunto)
            ->attachData($pdf->output(), $filenamePdf)
            ->attach(Excel::download(new RomaneoExport($this->nroAviso), $filenameExcel)->getFile(), ['as' => $filenameExcel]);
    }
}
