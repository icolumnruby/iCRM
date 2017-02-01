@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Product Category</h3>

@if (count($user))

<form method="POST" action="{!! route('branch.index') !!}" class="input-form">
  {!! csrf_field() !!}
  <input type="hidden" name="company_id" value="{!! $user->company_id !!}" />
  <div class="input-field">
      <input type="text" name="name" id="name" required=""/>
      <label for="name">Name</label>
  </div>
  <div class="input-field">
      <textarea name="address" id="address" rows="2" class="materialize-textarea"></textarea>
      <label for="address">Address</label>
  </div>
  <div class="row">
    <div class="col s12">
      <div class="switch">
        <label>
          Inactive
          <input type="checkbox" name="isActivated" id="isActivated" value="Y" checked="checked">
          <span class="lever"></span>
          Active
        </label>
      </div>
    </div>
  </div>
  <button type="submit" class="btn brand-gradient">Add Category</button>
</form>

@endif

@stop
