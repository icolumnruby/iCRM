@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Rewards</h3>

<form method="POST" action="{!! route('rewards.index') !!}" name="frmReward" class="form-horizontal" id="frmReward">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $user->company_id !!}" />
    <div class="input-field required">
        <label for="name">Name</label>
        <div class="col-xs-4">
            <input type="text" name="name" id="name" placeholder="" value="{!! old('name') !!}" />
        </div>
    </div>
    <div class="input-field">
        <label for="description">Description</label>
        <div class="col-xs-4">
            <textarea name="description" id="description" placeholder="" rows="2" class="materialize-textarea">{!! old('description') !!}</textarea>
        </div>
    </div>
    <div class="input-field">
        <label for="quantity">Quantity</label>
        <div class="col-xs-4">
            <input type="text" name="quantity" id="quantity" placeholder="" value="{!! old('quantity') !!}" />
        </div>
    </div>
    <div class="input-field required">
        <label for="points">Points</label>
        <div class="col-xs-4">
            <input type="text" name="points" id="points" placeholder="" value="{!! old('points') !!}" />
        </div>
    </div>
    <div class="input-field">
      <input type="text" class="flatpickr" id="startDate" name="startDate" value="{!! old('startDate') !!}">
      <label for="startDate">Start Date</label>
    </div>
    <div class="input-field">
      <input type="text" class="flatpickr" id="endDate" name="endDate" value="{!! old('endDate') !!}">
      <label for="endDate">End Date</label>
    </div>
    <div class="input-field required">
      <input type="number" name="dailyLimit" id="dailyLimit" placeholder="" value="{!! old('dailyLimit') !!}" />
      <label for="dailyLimit">Daily Limit</label>
    </div>
    <div class="input-field required">
      <input type="number" name="monthlyLimit" id="monthlyLimit" placeholder="" value="{!! old('monthlyLimit') !!}" />
      <label for="monthlyLimit">Monthly Limit</label>
    </div>
    <div class="input-field required">
      <input type="number" name="memberLimit" id="memberLimit" placeholder="" value="{!! old('memberLimit') !!}" />
      <label for="memberLimit">Member Limit</label>
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

    <button type="submit" class="btn brand-gradient" name="addContact">Save</button>
</form>

<script type="text/javascript">
$(document).ready(function(){
  flatpickr(".flatpickr", {
   enableTime: true,
   enableSeconds: true,
   altInput: true,
   altFormat: "F j, Y h:i K"
  });
 });
</script>
@stop
