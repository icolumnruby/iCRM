@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Loyalty Settings</h3>

<form method="POST" action="{!! route('loyalty.index') !!}" name="frmLoyalty" class="form-horizontal" id="frmLoyalty">
    {!! csrf_field() !!}
    <div class="input-field required">
        <select id="memberTypeId" name="memberTypeId">
            <option value="" disabled selected>Please Choose</option>
    @foreach (App\Models\Member::$_memberType as $key => $val)
            <option value="{!!$key!!}" {!! $key == old('memberTypeId') ? 'selected="selected"' : '' !!}>{!!$val!!}</option>
    @endforeach
        </select>
        <label for="memberType" class="col-xs-2 control-label">Member Type</label>
    </div>
    <div class="input-field required">
        <input type="text" name="name" id="name" placeholder="" value="{!! old('name') !!}" />
        <label for="name">Name</label>
    </div>
    <div class="input-field">
        <textarea name="description" id="description" placeholder="" rows="2" class="materialize-textarea">{!! old('description') !!}</textarea>
        <label class="col-xs-2 control-label">Description</label>
    </div>
    <div class="input-field required">
        <select id="actionId" name="actionId">
            <option value="" disabled selected>Choose One</option>
        @foreach (App\Models\LoyaltyConfig::$_action as $key => $val)
            <option value="{!! $key !!}" {!! $key == old('actionId') ? 'selected="selected"' : '' !!}>{!! $val !!}</option>
        @endforeach
        </select>
        <label for="typeId" class="control-label col-xs-2">Action</label>
    </div>
    <div class="input-field required">
        <select id="actionType" name="actionType">
            <option value="" disabled selected>Choose One</option>
            <option value="+" {!! '+' == old('actionType') ? 'selected="selected"' : '' !!}>Add</option>
            <option value="-" {!! '-' == old('actionType') ? 'selected="selected"' : '' !!}>Deduct</option>
        </select>
        <label for="typeId" class="control-label col-xs-2">Action Type</label>
    </div>
    <div class="input-field">
        <input type="text" name="value" id="value" placeholder="" value="{!! old('value') !!}" />
        <label for="value">Spending Amount ($)</label>
    </div>
    <div class="input-field required">
        <input type="text" name="points" id="points" placeholder="" value="{!! old('points') !!}" />
        <label for="points">Earning Point</label>
    </div>
    <div class="input-field">
      <input type="text" id="expiry" name="expiry" min="{!! date('Y-m-d') !!}" value="{!! old('expiry') !!}">
      <label for="expiry">Points Expiry</label>
    </div>
    <div class="input-field">
      <input type="text" class="flatpickr" id="startDate" name="startDate">
      <label for="startDate">Start Date</label>
    </div>
    <div class="input-field">
      <input type="text" class="flatpickr" id="endDate" name="endDate">
      <label for="endDate">End Date</label>
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

    <button type="submit" class="btn brand-gradient">Save</button>
</form>
<script type="text/javascript">
   $(document).ready(function(){
     flatpickr(".flatpickr", {
     	enableTime: true,
      enableSeconds: true,
      altInput: true,
	    altFormat: "F j, Y h:i K"
     });
     flatpickr("#expiry", {
       altInput: true,
       altFormat: "F j, Y h:i K"
     });
    });
</script>

@stop
