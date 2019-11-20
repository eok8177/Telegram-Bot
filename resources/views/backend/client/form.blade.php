  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="first_name">first_name</label>
      <div class="col-sm-10">
        <input type="text" name="first_name" value="{{$client->first_name}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="sur_name">sur_name</label>
      <div class="col-sm-10">
        <input type="text" name="sur_name" value="{{$client->sur_name}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="last_name">last_name</label>
      <div class="col-sm-10">
        <input type="text" name="last_name" value="{{$client->last_name}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" dob="email">dob</label>
      <div class="col-sm-10">
        <input type="text" name="dob" value="{{$client->dob}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="address">address</label>
      <div class="col-sm-10">
        <input type="text" name="address" value="{{$client->address}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="gender">gender</label>
      <div class="col-sm-10">
        <input type="text" name="gender" value="{{$client->gender}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="spasport">spasport</label>
      <div class="col-sm-10">
        <input type="text" name="spasport" value="{{$client->spasport}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="npasport">npasport</label>
      <div class="col-sm-10">
        <input type="text" name="npasport" value="{{$client->npasport}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="wpasport">wpasport</label>
      <div class="col-sm-10">
        <input type="text" name="wpasport" value="{{$client->wpasport}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="dpasport">dpasport</label>
      <div class="col-sm-10">
        <input type="text" name="dpasport" value="{{$client->dpasport}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" inn="email">inn</label>
      <div class="col-sm-10">
        <input type="text" name="inn" value="{{$client->inn}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="city">city</label>
      <div class="col-sm-10">
        <input type="text" name="city" value="{{$client->city}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="country">country</label>
      <div class="col-sm-10">
        <input type="text" name="country" value="{{$client->country}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="phone_1">phone_1</label>
      <div class="col-sm-10">
        <input type="text" name="phone_1" value="{{$client->phone_1}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="phone_2">phone_2</label>
      <div class="col-sm-10">
        <input type="text" name="phone_2" value="{{$client->phone_2}}" class="form-control">
      </div>
  </div>


<div class="form-group row">
  <input type="submit" value="save" class="btn btn-secondary">
</div>

