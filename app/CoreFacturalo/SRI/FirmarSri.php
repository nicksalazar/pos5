<?php
namespace App\CoreFacturalo\SRI;

use App\CoreFacturalo\SRI\Firma;
use Illuminate\Support\Facades\Log;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of firmar
 *
 * @author UESR
 */
class FirmarSri {
    //put your code here
    
    public function Firma_SRI($clave, $ruta_firma, $contrasena, $content){

        //$docGenerados = FCPATH.'public/archivos/generados';
        
        
        //$docFirmados = FCPATH.'public/archivos/firmados';

        /*if (file_exists($docGenerados . DIRECTORY_SEPARATOR . $clave . '.xml') === false)
            return array('error' => true, 'mensaje' => 'documento generado no existe');
        */

        //Log::info('ruta firma: '.$ruta_firma);
        //Log::info('pss: '.$contrasena);
        //Log::info('clave: '.$clave);
        //Log::info('content: '.$content);

        $config = array(
            'file' => $ruta_firma,
            'pass' => $contrasena
        );
        
        
        
        /*  $config = array(
            'file' => FCPATH.'public/archivos/leidy_melissa_rodriguez_solorzano.p12',
            'pass' => '2200456701Leidy'
        );*/

        $firma = new Firma($config, $clave);
          
        $resp = $firma->verificarCertPKey();
        
        if ($resp["error"] === true)
            return $resp;

        //$xml = file_get_contents($docGenerados. DIRECTORY_SEPARATOR . $clave . '.xml', FILE_USE_INCLUDE_PATH);
       // var_dump($xml);

        $doc = $this->getDocXml($content);
        $resp = $firma->firmar($content , '$docFirmados');

        //$signedfile = FCPATH.'public/archivos/firmados/'.$clave.'.xml';
        //return file_exists($signedfile);
        //Log::info('result : '.$resp);

        return $resp;
        
    }  

    private function getDocXml($content)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($content);

        return $doc;
    }

}