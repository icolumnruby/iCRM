@extends('layouts/admin')

@section('content')
<div class="row center-align">
  <p class="headline">Brand Your Membership</p>
  <h4>Upload your logo and Membership Pass image</h4>
  <div class="pass-template" style="background-color: '{!! $passTemplate->background_colour !!}'; color: '{!! $passTemplate->foreground_colour !!}'">
    <div class="pass-header-section">
      <form action="{!! url('company/save-pass-images') !!}" class="dropzone image-drop valign-wrapper" id="logo-input" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="imageType" value="logo">
        <input type="hidden" name="passTemplateId" value="{!! $passTemplate->passslot_id !!}">
        <div class="dz-message" data-dz-message><span>Drop Logo Here</span></div>
        </form>
      <div class="pass-inner">
        <p class="pass-label">Member Type</p>
        <p class="pass-value">Platinum</p>
      </div>
    </div>
    <div class="pass-strip-section">
      <form action="{!! url('company/save-pass-images') !!}" class="dropzone image-drop valign-wrapper" id="strip-input" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="imageType" value="strip">
        <input type="hidden" name="passTemplateId" value="{!! $passTemplate->passslot_id !!}">
        <div class="dz-message" data-dz-message><span>Drop Strip Image Here</span></div>
      </form>
      <div class="pass-inner">
        <h1 class="skinny pass-value white-text">888</h1>
        <p class="pass-label">Points</p>
      </div>
    </div>
    <div class="pass-secondary-section">
      <div class="pass-inner">
        <p class="pass-label">Member Name</p>
        <h4 class="skinny pass-value">Alex Applesmith</h4>
      </div>
    </div>
    <div class="pass-barcode-section">
      <div class="barcode-box center-align">
        <span>Barcode</span>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col s12">
      <a href="{{url('setup')}}" class="btn brand-ghost">Back</a>
      <a class="btn brand-gradient">Next</a>
    </div>
  </div>
  <p class="caption">Next Step: Add Branches</p>
</div>
<script type="text/javascript">
jQuery(function() {
  Dropzone.options.logoInput = {
    paramName: "image",
    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 3,
    thumbnailWidth:"375",
    success: function(file, response){
        //alert(response);
        console.log(response);
    }
  };
  Dropzone.options.stripInput = {
    paramName: "image",
    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 3,
    thumbnailWidth:"375",
    success: function(file, response){
        //alert(response);
        console.log(response);
    }
  };
});
</script>
@stop
