<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Exports\ReporteExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use \Mail;

use App\User;
use App\Usuario_Preferencias_Correo;
use App\Entregador_Contacto;
use App\Filtro;
use DB;


class ReporteSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $asunto;
    protected $cuerpo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($asunto, $cuerpo)
    {
        $this->asunto = $asunto;
        $this->cuerpo = $cuerpo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asunto = $this->asunto;
        $cuerpo = $this->cuerpo;

        $hoy = date("Y-m-d");
        $filename = "Reporte General de Descargas " . $hoy . ".pdf";
        $nombreUsuario = auth()->user()->nombre;
        $entregadorAutenticado = auth()->user()->idUser;
        $filtro = Filtro::first();
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

        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('exports.reporte-pdf', compact([
            'avisos', 'domicilio', 'entregador', 'contactos', 'fechadesde', 'fechahasta',
        ]));
        $pdf->setPaper('oficio', 'landscape');

        $filenameExcel = "Resumen General de Avisos de Descargas " . $hoy . ".xlsx";
        $filenamePdf = "Resumen General de Avisos de Descargas " . $hoy . ".pdf";

        $preferencias = Usuario_Preferencias_Correo::where('idUser', $entregadorAutenticado)->first();
        $email = Entregador_Contacto::where('id', $preferencias->email)->first();

        return $this->view('mails.romaneo_mail', compact(['cuerpo']))
            ->subject($asunto)
            ->replyTo($email->contacto, $nombreUsuario)
            ->attachData($pdf->output(), $filenamePdf)
            ->attach(Excel::download(new ReporteExport($filtro->idFiltro), $filenameExcel)->getFile(), ['as' => $filenameExcel]);
    }
}
