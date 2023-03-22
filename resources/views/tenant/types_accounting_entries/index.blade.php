@extends('tenant.layouts.app')

@section('content')

    <tenant-typesaccountingentries-index
        :type-user="{{json_encode(Auth::user()->type)}}" 
    ></tenant-typesaccountingentries-index>
    

@endsection
