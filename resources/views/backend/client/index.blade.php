@extends('backend.layouts.app')

@section('content')

<h2 class="page-header">clients</h2>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">actions</th>
        <th scope="col">name</th>
        <th scope="col">dob</th>
        <th scope="col">address</th>
        <th scope="col">gender</th>
        <th scope="col">inn</th>
        <th scope="col">phone_1</th>
        <th scope="col">phone_2</th>
      </tr>
    </thead>
    @foreach($clients as $client)
      <tr>
        <td>
          <a href="{{ route('admin.client.edit',    ['client'=>$client->id]) }}" class="btn fa fa-pencil"></a>
          <a href="{{ route('admin.client.destroy', ['client'=>$client->id]) }}" class="btn fa fa-trash-o delete-item"></a>
        </td>
        <td>{{$client->last_name}} {{$client->first_name}} {{$client->sur_name}}</td>
        <td>{{$client->dob}}</td>
        <td>{{$client->address}}</td>
        <td>{{$client->gender}}</td>
        <td>{{$client->inn}}</td>
        <td>{{$client->phone_1}}</td>
        <td>{{$client->phone_2}}</td>
      </tr>

    @endforeach
  </table>
</div>



@endsection