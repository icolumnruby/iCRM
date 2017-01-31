@extends('layouts/admin')

@section('content')
<div class="row center-align">
  <p class="headline">Create Membership Passes</p>
  <h4>Add a name and description for your Membership Pass</h4>
  <form method="POST" action="{!! url('company/save-pass-template') !!}" name="formPassTemplate" id="formPassTemplate" class="input-form">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $loggedIn->company_id !!}" />
    <div class="input-field">
        <input type="text" name="name" id="name" placeholder="" required=""/>
        <label for="name">Template Name</label>
    </div>
    <div class="input-field">
        <input type="text" name="logoText" id="logoText" placeholder="" required=""/>
        <label for="logoText">Brand Name</label>
    </div>
    <div class="input-field">
        <textarea name="description" id="description" placeholder="" rows="2" class="materialize-textarea"></textarea>
        <label for="description">Description</label>
    </div>
    <h5>Select your brand colours</h5>
    <div class="input-field colorpicker file-field" data-align="left">
        <div class="btn"></div>
        <div class="file-path-wrapper">
          <input type="text" name="backgroundColor" id="backgroundColor" placeholder="" required=""/>
        </div>
        <label for="backgroundColor" class="active">Background Colour</label>
    </div>
    <div class="input-field colorpicker file-field" data-align="left">
        <div class="btn"></div>
        <div class="file-path-wrapper">
          <input type="text" name="foregroundColor" id="foregroundColor" placeholder="" required=""/>
        </div>
        <label for="foregroundColor" class="active">Foreground Colour</label>
    </div>
    <a href="{{url('setup')}}" class="btn brand-ghost">Back</a>
    <button type="submit" class="btn brand-gradient" name="createTemplate">Next</button>
  </form>
  <p class="caption">Next Step: Brand Your Membership</p>
</div>
@stop
