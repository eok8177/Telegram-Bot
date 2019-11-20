
<input type="text" name="" class="autofeel-hack">
<input type="password" name="" class="autofeel-hack">


  <div class="form-group">
    <label for="name">name</label>
    <input type="text" name="name" value="{{$user->name}}" class="form-control">
  </div>

  <div class="form-group">
    <label for="email">email</label>
    <input type="text" name="email" value="{{$user->email}}" class="form-control">
  </div>

  <hr>

  <div class="form-group">
    <label for="">new_password</label>
    <input type="password" name="password" class="form-control">
  </div>


<div class="form-group">
  <input type="submit" value="save" class="btn btn-secondary">
</div>

@push('styles')
  <style type="text/css">
    .autofeel-hack {
      position: absolute;
      top: -999px;
    }
  </style>
@endpush