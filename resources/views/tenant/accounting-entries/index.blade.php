@extends('tenant.layouts.app')

@section('content')

    <tenant-accountingentries-index
    	:type-user="{{json_encode(Auth::user()->type)}}"
    	:soap-company="{{ json_encode($soap_company) }}"
    	:generate-order-note-from-quotation="{{ json_encode($generate_order_note_from_quotation) }}">
    </tenant-accountingentries-index>

@endsection
