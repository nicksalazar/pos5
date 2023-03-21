@extends('tenant.layouts.app')

@section('content')
    <tenant-accountingentries-form
        :type-user="{{json_encode(Auth::user()->type)}}"
        :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
    ></tenant-accountingentries-form>
@endsection
