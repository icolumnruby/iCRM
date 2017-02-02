@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Member Points</h3>

@if (count($member))
<form method="POST" action="{!!url('member/save-points')!!}" name="frmAddPoints" class="form-horizontal" id="frmAddPoints">
    {!! csrf_field() !!}
    <div class="row">
      <div class="input-field col m4">
        <p class="form-control-static">{!! $member->id !!}</p>
        <input type="hidden" name="memberId" id="memberId" value="{!! $member->id !!}" />
        <label for="memberId" class="active">Member ID</label>
      </div>
      <div class="input-field col m4">
        <p class="form-control-static">{!! $member->lastname .', '. $member->firstname !!}</p>
        <label class="active">Name</label>
      </div>
      <div class="input-field col m4">
        <p class="form-control-static">{!! App\Models\Member::$_memberType[$member->member_type_id] !!}</p>
        <label class="active">Member Type</label>
      </div>
    </div>
    <div class="input-field required">
      <select id="loyaltyConfigId" name="loyaltyConfigId">
          <option value="" disabled selected>Choose One</option>
      @foreach ($loyaltyConfig as $val)
          @if ($val->action_id != 1)
          <option value="{!! $val->id !!}" {!! old('loyaltyConfigId') == $val->id ? 'selected="selected"' : ''  !!}>{!! $val->name . ' (' . $val->type . $val->points . 'pts)' !!}</option>
          @endif
      @endforeach
      </select>
      <label for="paymentType">Action</label>
    </div>
    <div class="input-field">
      <textarea type="text" rows="2" name="remarks" id="remarks" class="materialize-textarea">{!! old('remarks') !!}</textarea>
      <label for="remarks">Remarks</label>
    </div>

    <button type="submit" class="btn brand-gradient" name="addMember">Update Points</button>
</form>

@endif

<script type="text/javascript">
$(function() {

});
</script>
@stop
