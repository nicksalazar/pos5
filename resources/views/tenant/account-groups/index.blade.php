@extends('tenant.layouts.app')

@section('content')

    <tenant-accountgroups-index
        :type-user="{{json_encode(Auth::user()->type)}}" 
    ></tenant-accountgroups-index>
    

@endsection
