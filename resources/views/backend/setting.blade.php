@extends('backend.layouts.app')

@section('content')
<div class="container">
  @if(Session::has('status'))
    <div class="alert alert-info">
      <span>{{ Session::get('status') }}</span>
    </div>
  @endif


    <form action="{{ route('admin.setting.store') }}" method="post">
        {{ csrf_field() }}

        <label>URL callback для TelegraBot</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Действие
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="document.getElementById('url_callback_bot').value = '{{ url('') }}'">Вставить url</a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('setwebhook').submit();">Отправить url</a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('getwebhookinfo').submit();">Получить информацию</a>
              </div>
            </div>
          </div>
          <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot" value="{{ $url_callback_bot ?? '' }}">
        </div>

        <button class="btn btn-primary" type="submit">Сохранить</button>
    </form>

    <form action="{{ route('admin.setting.setwebhook') }}" id="setwebhook" method="post" style="display: none;">
      {{ csrf_field() }}
      <input type="hidden" name="url" value="{{ $url_callback_bot ?? '' }}">
    </form>
    <form action="{{ route('admin.setting.getwebhookinfo') }}" id="getwebhookinfo" method="post" style="display: none;">{{ csrf_field() }}</form>
</div>
@endsection