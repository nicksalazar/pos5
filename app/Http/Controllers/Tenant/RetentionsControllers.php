<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Xml\XmlFormat;
use App\CoreFacturalo\SRI\FirmarSri;
use App\CoreFacturalo\Template;
use App\CoreFacturalo\WS\Services\BillSender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\PaymentMethodType;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\PurchasePayment;
use App\Models\Tenant\RetentionsDetailEC;
use App\Models\Tenant\RetentionsEC;
use App\Models\Tenant\SriFormasPagos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RetentionsControllers extends Controller
{
    const CREADA = '01';
    const GENERADA = '02';
    const RECIBIDA = '03';
    const DEVUELTA = '04';
    const AUTORIZADA = '05';
    const NOAUTORIZADA = '06';
    const RECHAZADA = '07';

    protected $configuration;
    protected $company;
    protected $isDemo;
    protected $ambienteLocal;
    protected $isOse;
    protected $isSRI;
    protected $purchase;
    protected $xmlUnsigned;
    protected $xmlSigned;
    protected $type;
    protected $clave_acceso;
    protected $pathCertificate;
    protected $urlSri;
    protected $soapUsername;
    protected $soapPassword;
    protected $endpoint;

    public function __construct()
    {
        $this->configuration = Configuration::first();
        $this->company = Company::active();
        $this->isDemo = ($this->company->soap_type_id === '01') ? true : false;
        $this->ambienteLocal = ($this->company->soap_type_id === '01') ? 1 : 2;
        $this->isOse = ($this->company->soap_send_id === '02') ? true : false;
        $this->isSRI = ($this->company->soap_send_id === '03') ? true : false;
        $this->type = 'retentionEC';

    }
    public function loadXmlSigned($file)
    {
        $this->xmlSigned = Storage::disk('tenant')->get('signed',$file);

        return $this;
    }

    private function prepareDocument($id){

        $purchaseL = Purchase::findOrFail($id);
        $retencionL = RetentionsEC::where('idDocumento', $id)->get();
        if($retencionL->count() > 0 ){
            $establecimiento = Establishment::findOrFail($purchaseL->establishment_id);
            $retencioneDetallesL = RetentionsDetailEC::where('idRetencion',$retencionL[0]->idRetencion)->get();
            $formasPago = PurchasePayment::where('purchase_id',$id)->get();

            $clave = "" . date('dmY', strtotime($retencionL[0]->created_at)) . "03" . $this->company->number."".substr($this->company->soap_type_id,1,1)."".substr($retencionL[0]->idRetencion,1)."" . str_pad('12345678', '8', '0', STR_PAD_LEFT) . "" . 1 . "";
            $digito_verificador_clave = $this->validar_clave($clave);
            $this->clave_acceso = $clave . "" . $digito_verificador_clave . "";
            $retencion = null;

            if($purchaseL && $purchaseL->count() > 0 ){

                $retencion = [
                    'ambiente'=>$this->ambienteLocal,
                    'emision' => 1,
                    'razonSocial' => $this->company->name,
                    'nombreComercial' => $this->company->trade_name,
                    'ruc' => $this->company->number,
                    'claveAcceso' => $this->clave_acceso,
                    'codDoc' => '03',
                    'establecimiento' => $retencionL[0]->establecimiento,
                    'ptoEmision'=> substr($retencionL[0]->ptoEmision,1),
                    'secuencial'=>substr($retencionL[0]->idRetencion,7),
                    'dirMatriz' => $establecimiento->address,
                    'fechaEmision' => $retencionL[0]->created_at->format('d/m/Y'),
                    'disEstablecimiento' => $establecimiento->address,
                    'contribuyenteEspecial' => $this->company->contribuyente_especial_num,
                    'obligadoContabilidad' => ($this->company->obligado_contabilidad > 0 ) ? 'SI':'NO',
                    'tipoIdentificacionSujetoRetenido' => str_pad($purchaseL->supplier->identity_document_type_id, '2', '0', STR_PAD_LEFT),
                    'parteRel' => 'NO',
                    'razonSocialSujetoRetenido' => $purchaseL->supplier->name,
                    'identificacionSujetoRetenido' => $purchaseL->supplier->number,
                    'periodoFiscal'=> $retencionL[0]->created_at->format('m/Y'),
                    'codSustento' => $purchaseL->codSustento,
                    'codDocSustento' => $purchaseL->document_type_id,
                    'numDocSustento' => $purchaseL->sequential_number,
                    'fechaEmisionDocSustento' => $retencionL[0]->created_at->format('m/Y'),
                    'numAutDocSustento' => $purchaseL->auth_number,
                    'pagoLocExt' => '01',
                    'totalSinImpuestos' => $purchaseL->total_value,
                    'importeTotal' => $purchaseL->total,

                    'baseImponible0' => ($purchaseL->total_unaffected) ? $purchaseL->total_unaffected :0,
                    'baseImponible12' => ($purchaseL->total_taxed)? $purchaseL->total_taxed:0,
                    'valorIva12' => ($purchaseL->total_igv) ? $purchaseL->total_igv:0,

                    'retenciones' => $retencioneDetallesL->transform(function($row, $key) {
                        return [
                            'codigo' => $key + 1,
                            'codigoRetencion' => $row->codRetencion,
                            'baseImponible' => $row->baseRet,
                            'porcentajeRetener' => $row->porcentajeRet,
                            'valorRetenido' => $row->valorRet,
                        ];
                    }),
                    'fpagos' => ($formasPago->count() > 0 )? $formasPago->transform(function($row, $key) {
                        $pagoSRI = PaymentMethodType::find($row->payment_method_type_id);
                        return [
                            'formaPago' => $pagoSRI->pago_sri,
                            'total' => $row->payment,
                        ];
                    }): [],



                ];
            }

            $retencionL[0]->update([
                'claveAcceso'=>$this->clave_acceso
            ]);
            return $retencion;
        }else{
            return false;
        }

    }

    public function validateDocumentSRI(){

        $url = null;
        if($this->isDemo){

            $url = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl";

        }else{

            $url = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl";
        }

        $request = new AuthSri();
        $authSRI = $request->send($url,$this->document->clave_SRI);

        if($authSRI != ''){

            $mensaje = null;
            $code = null;
            $estado = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado'];

            if($estado == 'RECHAZADA'){

                //$this->updateStateDocuments(self::REJECTED);
                $this->document->update([
                    'state_type_id' => self::REJECTED
                ]);
                $code = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['identificador'];
                $mensaje = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'];

            }elseif($estado == 'AUTORIZADO'){

                $fechaAutorizado = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['fechaAutorizacion'];
                $fechaArray = explode('T',$fechaAutorizado);
                //Log::info('gettype: '.$fechaArray[0].' -- '.substr($fechaArray[1],0,8));


                $this->document->update([
                    'state_type_id' => self::ACCEPTED
                ]);

                $this->document->date_authorization = $fechaArray[0];
                $this->document->time_authorization = substr($fechaArray[1],0,8);
                $this->document->update();

                $code = 200;
                $mensaje = 'DOCUMENTO AUTORIZADO POR EL SRI';
                $documento = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['comprobante'];

                $this->uploadFile($documento, 'autorizado');
                $tipodoc = '';
                if($this->document->document_type_id === '01'){
                    $tipodoc = 'invoice';
                    $this->doc_type = '01';

                }else if($this->document->document_type_id === '07'){

                    $tipodoc = 'note';
                    $this->doc_type = '07';
                }
                $this->actions['format_pdf'] = 'blank';
                $this->createPdf($this->document, $tipodoc, 'a4');
                $temp = tempnam(sys_get_temp_dir(), 'pdf');
                file_put_contents($temp, $this->getStorage($this->document->filename, 'pdf'));
                $this->sendEmail2();

            }elseif($estado == 'NO AUTORIZADO'){

                //Log::info('ESTADO: '.$estado);

                $this->document->update([
                    'state_type_id' => self::NOACCEPTED
                ]);
                $code = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['identificador'];
                $mensaje = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'];

            }elseif($estado == 'EN PROCESO'){

                //Log::info('ESTADO: '.$estado);

                $this->document->update([
                    'state_type_id' => self::OBSERVED
                ]);
                $code = 300;
                $mensaje = 'DOCUMENTO EN PROCESO';

            }
            else{

                $this->document->update([
                    'state_type_id' => self::OBSERVED
                ]);
                if($authSRI['RespuestaAutorizacionComprobante']['numeroComprobantes'] > 0){
                    $code = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['identificador'];
                    $mensaje = $authSRI['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'];
                }else{

                    $code = 500;
                    $mensaje = 'NO SE ENCONTRO EL DOCUMENTO EN EL SISTEMA DEL SRI';

                }

            }

            $this->response = [
                'sent' => true,
                'code' => $code,
                'description' => $mensaje,
                'notes' => $estado
            ];

            $this->document->update([
                'regularize_shipping' => false,
                'response_regularize_shipping' => [
                    'code' => $code,
                    'description' => $estado
                ]
            ]);
        }else{

            $this->response = [
                'sent' => true,
                'code' => 500,
                'description' => 'NO SE PUDO VALIDAR EL DOCUMENTO EN EL SRI',
                'notes' => 'INTENTELO MAS TARDE'
            ];

            $this->document->update([
                'regularize_shipping' => false,
                'response_regularize_shipping' => [
                    'code' => 500,
                    'description' => 'NO SE PUDO VALIDAR EL DOCUMENTO EN EL SRI'
                ]
            ]);
        }

    }

    public function sendXmlSigned($file)
    {
        $this->setDataSoapType();
        $this->setSoapCredentials();

        $sender = new BillSender();
        $this->loadXmlSigned($file);
        return $sender->send($this->urlSri, $this->xmlSigned);


    }

    public function createXML($id){

        $documento = $this->prepareDocument($id);
        if($documento){
            //Log::info('DOCUEMNTO AGENENRAR: '. json_encode($documento));
            $template = new Template();
            $this->xmlUnsigned = XmlFormat::format($template->xml($this->type, $this->company, $documento,null));
            $nombre = "unsigned/" . $this->clave_acceso . ".xml";
            Storage::disk('tenant')->put($nombre, $this->xmlUnsigned);
            $this->firmarXML();
            $nombre2 = "signed/" . $this->clave_acceso . ".xml";
            Storage::disk('tenant')->put($nombre2, $this->xmlSigned);

            return $this->clave_acceso;
        }else{
            return 'No se pueden generar retenciones del documento: ' . $id;
        }

    }

    private function firmarXML(){

        $this->setPathCertificate();
        $firma = new FirmarSri();
        $this->xmlSigned = $firma->Firma_SRI($this->clave_acceso, $this->pathCertificate,$this->company->certificate_pass,$this->xmlUnsigned);
    }

    private function setPathCertificate()
    {
        if($this->isOse) {
            $this->pathCertificate = storage_path('app'.DIRECTORY_SEPARATOR.'certificates'.DIRECTORY_SEPARATOR.$this->company->certificate);
        }else if($this->isSRI){

            $this->pathCertificate = storage_path('app'.DIRECTORY_SEPARATOR.'certificates'.DIRECTORY_SEPARATOR.$this->company->certificate);


        }else {
            if($this->isDemo) {
                $this->pathCertificate = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.
                    'WS'.DIRECTORY_SEPARATOR.
                    'Signed'.DIRECTORY_SEPARATOR.
                    'Resources'.DIRECTORY_SEPARATOR.
                    'certificate.pem');
            } else {
                $this->pathCertificate = storage_path('app'.DIRECTORY_SEPARATOR.
                    'certificates'.DIRECTORY_SEPARATOR.$this->company->certificate);
            }
        }
    }

    private function validar_clave($clave) {

        if ($clave == "") {
            $verificado = false;
            return $verificado;
        }

        $x = 2;
        $sumatoria = 0;
        for ($i = strlen($clave) - 1; $i >= 0; $i--) {
            if ($x > 7) {
                $x = 2;
            }
            $sumatoria = $sumatoria + ($clave[$i] * $x);
            $x++;
        }
        $digito = $sumatoria % 11;
        $digito = 11 - $digito;

        switch ($digito) {
            case 10:
                $digito = "1";
                break;
            case 11:
                $digito = "0";
                break;
        }
        return $digito;
    }

    private function setSoapCredentials()
    {

        if($this->isOse) {

            $this->soapUsername = $this->company->soap_username;
            $this->soapPassword = $this->company->soap_password;
            $this->endpoint = $this->company->soap_url;
            //            dd($this->soapPassword);

        }else{

            if($this->isSRI){
                if($this->isDemo){
                    $this->urlSri = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
                }else{
                    $this->urlSri = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
                }
            }else{
                if($this->isDemo) {
                    $this->soapUsername = $this->company->number.'MODDATOS';
                    $this->soapPassword = 'moddatos';
                } else {
                    $this->soapUsername = $this->company->soap_username;
                    $this->soapPassword = $this->company->soap_password;
                }
            }



        }


        // $this->soapUsername = ($this->isDemo)?$this->company->number.'MODDATOS':$this->company->soap_username;
        // $this->soapPassword = ($this->isDemo)?'moddatos':$this->company->soap_password;

        if($this->isOse) {


        }else {
            switch ($this->type) {
                case 'perception':
                case 'retention':
                    $this->endpoint = ($this->isDemo)?SunatEndpoints::RETENCION_BETA:SunatEndpoints::RETENCION_PRODUCCION;
                    break;
                case 'dispatch':
                    $this->endpoint = ($this->isDemo)?SunatEndpoints::GUIA_BETA:SunatEndpoints::GUIA_PRODUCCION;
                    break;
                default:
                    // $this->endpoint = ($this->isDemo)?SunatEndpoints::FE_BETA:SunatEndpoints::FE_PRODUCCION;
                    $this->endpoint = ($this->isDemo)?SunatEndpoints::FE_BETA : ($this->configuration->sunat_alternate_server ? SunatEndpoints::FE_PRODUCCION_ALTERNATE : SunatEndpoints::FE_PRODUCCION);
                    break;
            }
        }

    }

}
