@php
    //$establishment = $document->establishment;
@endphp
{!! '<?xml version="1.0" encoding="utf-8" standalone="no"?>' !!}
<comprobanteRetencion id="comprobante" version="2.0.0">
    <infoTributaria>
        <ambiente>{{ $document->ambiente }}</ambiente>
        <tipoEmision>{{ $document->emision }}</tipoEmision>
        <razonSocial>{{ $document->razonSocial }}</razonSocial>
        <nombreComercial>{{ $document->nombreComercial }}</nombreComercial>
        <ruc>{{ $document->ruc }}</ruc>
        <claveAcceso>{{ $document->claveAcceso }}</claveAcceso>
        <codDoc>{{ $document->codDoc }}</codDoc>
        <estab>{{ $document->establecimiento }}</estab>
        <ptoEmi>{{ $document->ptoEmision }}</ptoEmi>
        <secuencial>{{ $document->secuencial }}</secuencial>
        <dirMatriz>{{ $document->dirMatriz }}</dirMatriz>
    </infoTributaria>
</comprobanteRetencion>
