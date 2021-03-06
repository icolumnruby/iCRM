@extends('layouts/admin')

@section('content')
<div class="row">
  <p class="headline">Create Membership Passes</p>
  <h4>Add a name and description for your Membership Pass</h4>
  <form method="POST" action="{!! url('company/save-pass-template') !!}" name="formPassTemplate" id="formPassTemplate" class="input-form">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $loggedIn->company_id !!}" />
    <div class="input-field">
        <input type="text" name="name" id="name" required=""/>
        <label for="name">Template Name</label>
    </div>
    <div class="input-field">
        <textarea name="description" id="description" rows="2" class="materialize-textarea"></textarea>
        <label for="description">Description</label>
    </div>
    <h5>Select your brand colours</h5>
    <div class="input-field colorpicker file-field" data-align="left">
        <div class="btn"></div>
        <div class="file-path-wrapper">
          <input type="text" name="backgroundColor" id="backgroundColor" required=""/>
        </div>
        <label for="backgroundColor" class="active">Background Colour</label>
    </div>
    <div class="input-field colorpicker file-field" data-align="left">
        <div class="btn"></div>
        <div class="file-path-wrapper">
          <input type="text" name="foregroundColor" id="foregroundColor" required=""/>
        </div>
        <label for="foregroundColor" class="active">Foreground Colour</label>
    </div>
    <div class="center-align">
      <a href="{{ URL::previous() }}" class="btn brand-ghost">Back</a>
      <button type="submit" class="btn brand-gradient">Next</button>
    </div>
  </form>
  <p class="caption center-align">Next Step: Brand Your Membership</p>
</div>
@stop
