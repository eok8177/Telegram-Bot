@extends('backend.layouts.app')

@section('content')
<h2 class="page-header">new_user</h2>

{!! Form::open(['route' => ['admin.user.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('backend.user.form')
{!! Form::close() !!}

@endsection