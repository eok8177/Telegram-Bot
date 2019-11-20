@extends('backend.layouts.app')

@section('content')
<div class="container">
    <h5>Clients</h5>

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Actions</th>
          <th scope="col">Telegram ID</th>
          <th scope="col">Name</th>
          <th scope="col">Country</th>
          <th scope="col">City</th>
          <th scope="col">Address</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clients as $client)
        <tr>
          <td>
            <a href="{{ route('admin.client.edit',    ['client'=>$client->id]) }}" class="btn fa fa-pencil"></a>
            <a href="{{ route('admin.client.destroy', ['client'=>$client->id]) }}" class="btn fa fa-trash-o delete-item"></a>
          </td>
          <th scope="row">{{$client->t_id}}</th>
          <td>{{$client->last_name}} {{$client->first_name}} {{$client->sur_name}}</td>
          <td>{{$client->country}}</td>
          <td>{{$client->city}}</td>
          <td>{{$client->address}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>


    <h5>Telegram Users</h5>

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Telegram ID</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Current step</th>
          <th scope="col">Last message</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tUsers as $user)
        <tr>
          <th scope="row">{{$user->id}}</th>
          <td>{{$user->last_name}} {{$user->first_name}}</td>
          <td>{{$user->username}}</td>
          <td>{{$user->section}} {{$user->step}}</td>
          <td>{{$user->text}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endsection