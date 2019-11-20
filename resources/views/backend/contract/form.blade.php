  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="number">number</label>
      <div class="col-sm-10">
        <input type="text" name="number" value="{{$contract->number}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="amount">amount</label>
      <div class="col-sm-10">
        <input type="text" name="amount" value="{{$contract->amount}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="min_summ">min_summ</label>
      <div class="col-sm-10">
        <input type="text" name="min_summ" value="{{$contract->min_summ}}" class="form-control">
      </div>
  </div>
  <div class="form-group row">
      <label class="col-sm-2 col-form-label" for="saldo">saldo</label>
      <div class="col-sm-10">
        <input type="text" name="saldo" value="{{$contract->saldo}}" class="form-control">
      </div>
  </div>

<div class="form-group row">
  <input type="submit" value="save" class="btn btn-secondary">
</div>

