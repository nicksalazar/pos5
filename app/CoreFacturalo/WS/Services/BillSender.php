<?php

namespace App\CoreFacturalo\WS\Services;

use App\CoreFacturalo\WS\Response\BillResult;
use Illuminate\Support\Facades\Log;
use SoapClient;
use SoapHeader;
use nusoap_client;

/**
 * Class BillSender.
 */
class BillSender extends BaseSunat
{
    /**
     * @param string $filename
     * @param string $content agregar o quitar programas 
     *
     * @return mixed
     */
    public function send($filename, $content)
    {
        Log::info("url a enviar $filename");
        $response = null;
        $servicio = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl"; //url del servicio
        $client = new nusoap_client("$filename", 'wsdl');
        //$client = new WsClient('https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl');
        $client->soap_defencoding = 'UTF-8';
        ///$content = file_get_contents("C:laragon/www/POS/storage/app/tenancy/tenants/tenancy_vc/unsigned/1010202201179305477300120010010000002811234567818.xml");
        //$mensaje = base64_encode($content);
        $params = array(); 

        try {
            
            $params['xml'] = base64_encode($content);
            $response = $client->call("validarComprobante", $params, "http://ec.gob.sri.ws.recepcion");
            //Log::info('__getFunctions: '.json_encode($client->__getFunctions()));
            //Log::info('__getLastResponseHeaders: '.json_encode($client->__getLastResponseHeaders()));
            Log::info('gettype: '.gettype($response));
            Log::info('response: '.json_encode($response));
    
            
            $cdrZip = $response;
            /*$result
                //->setCdrResponse($response)
                ->setSRIResponse($response)
                ->setCdrZip($cdrZip)
                ->setSuccess(true);*/

        } catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
            return false;
        }
        //$fileObjeto = json_decode(json_encode($response, JSON_FORCE_OBJECT));
        return $response;
    }
}
