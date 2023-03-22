<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Xml\XmlFormat;
use App\CoreFacturalo\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\RetentionsEC;

class RetentionsControllers extends Controller
{
    const REGISTERED = '01';
    const SENT = '03';
    const ACCEPTED = '05';
    const NOACCEPTED = '09';
    const OBSERVED = '07';
    const REJECTED = '31';
    const CANCELING = '13';
    const VOIDED = '11';
    const RETURNED = '30';

    protected $configuration;
    protected $company;
    protected $isDemo;
    protected $ambienteLocal;
    protected $isOse;
    protected $isSRI;
    protected $purchase;
    protected $xmlUnsigned;
    protected $type;


    public function __construct()
    {
        $this->configuration = Configuration::first();
        $this->company = Company::active();
        $this->isDemo = ($this->company->soap_type_id === '01') ? true : false;
        $this->ambienteLocal = ($this->company->soap_type_id === '01') ? 1 : 2;
        $this->isOse = ($this->company->soap_send_id === '02') ? true : false;
        $this->isSRI = ($this->company->soap_send_id === '03') ? true : false;
        $this->type = 'retention';
    }



    private function prepareDocument($id){

        $purchaseL = Purchase::findOrFail($id);
        $retencionL = RetentionsEC::where('idDocumento', $id);
        $establecimiento = Establishment::findOrFail($purchaseL->establishment_id);

        $clave = "" . date('dmY', strtotime($$retencionL[0]->create_at)) . "03" . $this->company->number."".substr($this->company->soap_type_id,1,1)."".substr($retencionL[0]->idRetencion,1)."" . str_pad('12345678', '8', '0', STR_PAD_LEFT) . "" . 1 . "";
        $digito_verificador_clave = $this->validar_clave($clave);
        $clave_acceso = $clave . "" . $digito_verificador_clave . "";

        if($purchaseL && $purchaseL->count() > 0 ){
            $retencion = [
                'ambiente'=>$this->ambienteLocal,
                'emision' => 1,
                'razonSocial' => $this->company->name,
                'nombreComercial' => $this->company->trade_name,
                'ruc' => $this->company->number,
                'claveAcceso' => $clave_acceso,
                'codDoc' => '03',
                'establecimiento' => $retencionL[0]->establecimiento,
                'ptoEmision'=> substr($retencionL[0]->ptoEmision,1),
                'secuencial'=>substr($retencionL[0]->idRetencion,7),
                'dirMatriz' => $establecimiento->address,
                'fechaEmision' => $retencionL[0]->create_at->format('d/m/Y'),
                'disEstablecimiento' => $establecimiento->address,
                'contribuyenteEspecial' => $this->company->contribuyente_especial_num,
                'obligadoContabilidad' => $this->company->obligado_contabilidad,
                'tipoIdentificacionSujetoRetenido' => str_pad($purchaseL->supplier->identity_document_type_id, '2', '0', STR_PAD_LEFT),
                'parteRel' => 'NO',
                'razonSocialSujetoRetenido' => $purchaseL->supplier->name,
                'identificacionSujetoRetenido' => $purchaseL->supplier->number,
                'periodoFiscal'=> $retencionL[0]->create_at->format('m/Y'),
                'codSustento' => $purchaseL->codSustento,
                'codDocSustento' => $purchaseL->document_type_id,
                'numDocSustento' => $purchaseL->sequential_number,
                'fechaEmisionDocSustento' => $retencionL[0]->create_at->format('m/Y'),
                'numAutDocSustento' => $purchaseL->auth_number,
                'pagoLocExt' => '01',
                'totalSinImpuestos' => $purchaseL->total_value,
                'importeTotal' => $purchaseL->total,
                'impuestosDocSustento' => [
                    'baseImponible0' => $purchaseL->total_unaffected,
                    'baseImponible12' => $purchaseL->toal_taxed,
                    'valorIva12' => $purchaseL->total_igv,
                    
                ]


            ];
        }

    }

    public function createXML($id){

        $this->purchase = Purchase::findOrFail($id);
        if($this->purchase->count() > 0 ){

            $template = new Template();
            $this->xmlUnsigned = XmlFormat::format($template->xml($this->type, $this->company, $this->document,null));
            $this->uploadFile($this->xmlUnsigned, 'unsigned');
            return $this;

        }

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
