@extends('backend.layouts.app')

@section('content')

<h2 class="page-header">contracts</h2>

<a href="{{ route('admin.contract.create') }}" class="btn btn-outline-secondary mb-3">Create new contract</a>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">actions</th>
        <th scope="col">number</th>
        <th scope="col">amount</th>
        <th scope="col">min summ</th>
        <th scope="col">left summ</th>
      </tr>
    </thead>
    @foreach($contracts as $contract)
      <tr>
        <td>
          <a href="{{ route('admin.contract.edit',    $contract->id) }}" class="btn fa fa-pencil"></a>
          <a href="{{ route('admin.contract.destroy', $contract->id) }}" class="btn fa fa-trash-o delete-item"></a>
        </td>
        <td>{{$contract->number}}</td>
        <td>{{$contract->amount}}</td>
        <td>{{$contract->min_summ}}</td>
        <td>{{$contract->saldo}}</td>
      </tr>

    @endforeach
  </table>
</div>



@endsection