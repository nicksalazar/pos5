@extends('tenant.layouts.app')

@section('content')

    <tenant-accountmovements-index
        :type-user="{{json_encode(Auth::user()->type)}}" 
    ></tenant-accountmovements-index>
    

@endsection
