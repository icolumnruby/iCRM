@extends('layouts/admin')

@section('content')
<div class="row center-align">
  <p class="headline">Brand Your Membership</p>
  <h4>Upload your logo and Membership Pass image</h4>
  <form method="POST" action="{!! url('company/save-pass-template') !!}" name="formPassTemplate" id="formPassTemplate" class="input-form">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $loggedIn->company_id !!}" />
    <h5>Upload your logo</h5>
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input type="file">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
    <h5>Upload your pass image</h5>
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input type="file">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
    <a href="{{url('setup')}}" class="btn brand-ghost">Back</a>
    <button type="submit" class="btn brand-gradient" name="createTemplate">Next</button>
  </form>
  <p class="caption">Next Step: Add Branches</p>
</div>
@stop
