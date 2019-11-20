@extends('backend.layouts.app')

@section('content')

<h2 class="page-header">users</h2>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">actions</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
      </tr>
    </thead>
    @foreach($users as $user)
      <tr>
        <td>
          <a href="{{ route('admin.user.edit',    ['user'=>$user->id]) }}" class="btn fa fa-pencil"></a>
          <a href="{{ route('admin.user.destroy', ['user'=>$user->id]) }}" class="btn fa fa-trash-o delete-item"></a>
        </td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
      </tr>

    @endforeach
  </table>
</div>



@endsection