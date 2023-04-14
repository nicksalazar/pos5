@extends('tenant.layouts.app')

@section('content')
    <tenant-accountingentries-edit 
        :resource-id="{{json_encode($resourceId)}}" 
        :type-user="{{json_encode(Auth::user()->type)}}"
        :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}">
    </tenant-accountingentries-edit>
@endsection
