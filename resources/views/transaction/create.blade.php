@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Transaction</h3>

@if (count($member))
<form method="POST" action="{!!route('transaction.index')!!}" name="frmTxn" class="form-horizontal" id="frmTxn">
    {!! csrf_field() !!}
    <div class="row">
      <div class="input-field col m4">
            <p class="form-control-static">{!! $member->id !!}</p>
            <input type="hidden" name="memberId" id="memberId" value="{!! $member->id !!}" />
            <label for="memberId" class="active">Member ID</label>
      </div>
      <div class="input-field col m4">
          <p class="form-control-static">{!! $totalPoints !!}</p>
          <label class="active">Member Points</label>
      </div>
      <div class="input-field col m4">
          <p class="form-control-static">{!! App\Models\Member::$_memberType[$member->member_type_id] !!}</p>
          <label class="active">Member Type</label>
      </div>
    </div>
    <div class="input-field">
      <select id="productCategoryId" name="productCategoryId">
          <option value="" disabled selected>Please Choose</option>
  @if (count($categories))
      @foreach ($categories as $val)
          <option value="{!! $val->id !!}">{!! $val->name !!}</option>
      @endforeach
  @endif
      </select>
      <label for="productCategoryId">Product Category</label>
    </div>
    <div class="input-field required">
        <input type="text" name="amount" id="amount" placeholder="i.e. 800.75" />
        <label for="amount">Amount</label>
    </div>
    <div class="input-field">
      <select id="paymentType" name="paymentType">
          <option value="0" disabled selected>Choose One</option>
      @foreach ($paymentType as $key => $val)
          <option value="{!! $key !!}">{!! $val->name !!}</option>
      @endforeach
      </select>
      <label for="paymentType">Payment Type</label>
    </div>
    <div class="input-field">
      <select id="status" name="status">
          <option value="" disabled selected>Please Choose</option>
      @foreach (App\Models\Transaction::$_status as $key => $status)
          <option value="{!! $key !!}">{!! $status !!}</option>
      @endforeach
      </select>
      <label for="status">Status</label>
    </div>
    <div class="input-field">
        <textarea type="text" rows="2" name="remarks" id="remarks" class="materialize-textarea"></textarea>
        <label for="remarks">Remarks</label>
    </div>

    <button type="submit" class="btn brand-gradient" name="addMember">Add Transaction</button>
</form>

@endif

<script type="text/javascript">
$(function() {


});
</script>
@stop
