@extends('backend.layouts.app')

@section('content')
<h2 class="page-header">client<small>{{ $client->name }}</small></h2>

{!! Form::open(['route' => ['admin.client.update', $client->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('backend.client.form')
{!! Form::close() !!}

@endsection