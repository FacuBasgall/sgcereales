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
use App\Usuario_Preferencias_Correo;
use App\Aviso_Producto;
use App\Aviso_Entregador;
use App\Entregador_Contacto;
use App\Entregador_Domicilio;
use App\Corredor_Contacto;
use App\Localidad;
use App\Provincia;
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
        $entregadorAutenticado = auth()->user()->idUser;
        $filtros = Filtro::first();

        /**CARGA PDF */
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

        $pdf = PDF::loadView('exports.reporte-pdf', compact(['resultados', 'descargas', 'filtros', 'destinatarios', 'titulares',
        'intermediarios', 'remitentes', 'corredores', 'productos', 'entregador', 'localidades', 'provincias',
        'entregador_contacto', 'entregador_domicilio']));
        $pdf->setPaper('a4', 'landscape');

        $filenameExcel = "Reporte General de Descargas " . $hoy . ".xlsx";
        $filenamePdf = "Reporte General de Descargas " . $hoy . ".pdf";

        return $this->view('mails.romaneo_mail', compact(['cuerpo']))
            ->subject($asunto)
            ->attachData($pdf->output(), $filenamePdf)
            ->attach(Excel::download(new ReporteExport($filtros->idFiltro), $filenameExcel)->getFile(), ['as' => $filenameExcel]);
    }
}
