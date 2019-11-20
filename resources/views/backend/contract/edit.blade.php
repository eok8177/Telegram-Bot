@extends('backend.layouts.app')

@section('content')
<h2 class="page-header">contract<small>{{ $contract->name }}</small></h2>

{!! Form::open(['route' => ['admin.contract.update', $contract->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('backend.contract.form')
{!! Form::close() !!}

@endsection