@extends('backend.layouts.app')

@section('content')
<h2 class="page-header">user<small>{{ $user->name }}</small></h2>

{!! Form::open(['route' => ['admin.user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('backend.user.form')
{!! Form::close() !!}

@endsection