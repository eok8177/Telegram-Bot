@extends('backend.layouts.app')

@section('content')
<h2 class="page-header">new_contract</h2>

{!! Form::open(['route' => ['admin.contract.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('backend.contract.form')
{!! Form::close() !!}

@endsection