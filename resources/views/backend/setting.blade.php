@extends('backend.layouts.app')

@section('content')
<div class="container">
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
                <a class="dropdown-item" href="#">Отправить url</a>
                <a class="dropdown-item" href="#">Получить информацию</a>
              </div>
            </div>
          </div>
          <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot" value="{{ $url_callback_bot ?? '' }}">
        </div>

        <label>Название главной страницы</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="site_name" value="{{ $site_name ?? '' }}">
        </div>

        <button class="btn btn-primary" type="submit">Сохранить</button>
    </form>
</div>
@endsection