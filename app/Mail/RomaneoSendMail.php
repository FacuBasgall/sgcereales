<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Exports\RomaneoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use MultiMail;

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
use App\Corredor_Contacto;
use App\Localidad;
use App\Provincia;

class RomaneoSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $idAviso;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idAviso)
    {
        $this->idAviso = $idAviso;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $aviso = Aviso::where('idAviso', $this->idAviso)->first();
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
        $entregador = User::where('idUser', $aviso_entregador->idEntregador)->first();
        $entregador_contacto = Entregador_Contacto::where('idUser', $entregador->idUser)->get();
        $entregador_domicilio = Entregador_Domicilio::where('idUser', $entregador->idUser)->get();
        $localidad = Localidad::where('id', $aviso->localidadProcedencia)->first();
        $provincia = Provincia::where('id', $aviso->provinciaProcedencia)->first();

        $pdf = PDF::loadView('exports.pdf', compact(['aviso', 'titular', 'cargas', 'descargas', 'corredor',
            'destinatario', 'intermediario', 'producto', 'remitente', 'aviso_producto', 'aviso_entregador',
            'entregador', 'entregador_contacto', 'entregador_domicilio', 'localidad', 'provincia']));
        $pdf->setPaper('a4', 'landscape');

        $filenameExcel = $aviso->nroAviso . " " . $titular->nombre . ".xlsx";
        $filenamePdf = $aviso->nroAviso . " " . $titular->nombre . ".pdf";
        $asunto = "Envio del aviso nro: " . $aviso->nroAviso;

        $correosCorredor = Corredor_Contacto::where('cuit', $aviso->idCorredor)->where('tipo', 3)->pluck('contacto');

        return $this->view('mails.romaneo_mail')
            ->cc($correosCorredor)
            ->subject($asunto)
            ->attachData($pdf->output(), $filenamePdf)
            ->attach(Excel::download(new RomaneoExport($this->idAviso), $filenameExcel)->getFile(), ['as' => $filenameExcel]);
    }
}
