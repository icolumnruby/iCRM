@extends('layouts/admin')

@section('content')
<div class="row ">
  <p class="headline">Setup Product Categories</p>
  <h4>Add product categories</h4>
  <form method="POST" action="/product/category" class="input-form">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $user->company_id !!}" />
    <input type="hidden" name="setup" value="yes" />
    <div class="input-field">
        <input type="text" name="name" id="name" required=""/>
        <label for="name">Category Name</label>
    </div>
    <div class="input-field">
        <textarea name="description" id="description" rows="2" class="materialize-textarea"></textarea>
        <label for="description">Description</label>
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
  <p class="caption center-align">Next Step: End of Setup</p>
</div>
@stop
