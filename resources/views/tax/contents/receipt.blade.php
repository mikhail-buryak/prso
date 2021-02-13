@extends('tax.layouts.default')

@section('head')
    @include('tax.includes.head')
@stop

@section('content')
    @include('tax.includes.total')
    @include('tax.includes.pay')
    @include('tax.includes.tax')
    @include('tax.includes.body')
@stop
