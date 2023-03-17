@extends('tenant.layouts.app')

@section('content')

    <tenant-purchases-document-types
        :type-user="{{json_encode(Auth::user()->type)}}"
        :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
    ></tenant-purchases-document-types>

@endsection
