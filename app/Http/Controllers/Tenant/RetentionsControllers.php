<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Xml\XmlFormat;
use App\CoreFacturalo\Template;
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
    protected $type;
    protected $clave_acceso;


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



    private function prepareDocument($id){

        $purchaseL = Purchase::findOrFail($id);
        $retencionL = RetentionsEC::where('idDocumento', $id)->get();
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
    }

    public function createXML($id){

        $documento = $this->prepareDocument($id);
        if($documento){
            Log::info('DOCUEMNTO AGENENRAR: '. json_encode($documento));
            $template = new Template();
            $this->xmlUnsigned = XmlFormat::format($template->xml($this->type, $this->company, $documento,null));
            //$this->uploadFile($this->xmlUnsigned, 'unsigned');
            $nombre = "unsigned/" . $this->clave_acceso . ".xml";
            Storage::disk('tenant')->put($nombre, $this->xmlUnsigned);
            return $this->clave_acceso;
        }else{
            return 'No generado';
        }

    }
    public function firmarXML(){

    }

    public function validar_clave($clave) {

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

}
