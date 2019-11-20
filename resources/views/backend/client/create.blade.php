@extends('backend.layouts.app')

@section('content')
<h2 class="page-header">new_client</h2>

{!! Form::open(['route' => ['admin.client.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('backend.client.form')
{!! Form::close() !!}

@endsection