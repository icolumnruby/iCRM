@extends('layouts/admin')

@section('content')
<div class="row ">
  <p class="headline">Setup Branches</p>
  <h4>Add your branch name and location</h4>
  <form method="POST" action="{!! route('branch.index') !!}" name="formPassTemplate" id="formPassTemplate" class="input-form">
    {!! csrf_field() !!}
    <input type="hidden" name="company_id" value="{!! $user->company_id !!}" />
    <input type="hidden" name="setup" value="yes" />
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
    <div class="center-align">
      <a href="{{ URL::previous() }}" class="btn brand-ghost">Back</a>
      <button type="submit" class="btn brand-gradient">Next</button>
    </div>
  </form>
  <p class="caption center-align">Next Step: Add Managers</p>
</div>
@stop
