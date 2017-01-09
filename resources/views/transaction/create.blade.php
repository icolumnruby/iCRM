@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Transaction</h3>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {!! Session::get('flash_message') !!}
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (count($member))
<form method="POST" action="{!!route('transaction.index')!!}" name="frmTxn" class="form-horizontal" id="frmTxn">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">Member ID</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! $member->id !!}</p>
            <input type="hidden" name="memberId" id="memberId" value="{!! $member->id !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Member Points</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! $totalPoints !!}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Member Type</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! App\Models\Member::$_memberType[$member->member_type_id] !!}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Product Category</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="productCategoryId" name="productCategoryId">
                <option value="">Please Choose</option>
        @if (count($categories))
            @foreach ($categories as $val)
                <option value="{!! $val->id !!}">{!! $val->name !!}</option>
            @endforeach
        @endif
            </select>
        </div>
    </div>
    <div class="form-group required">
        <label for="amount" class="control-label col-xs-2">Amount</label>
        <div class="col-xs-4">
            <input type="text" name="amount" id="amount" placeholder="i.e. 800.75" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="paymentType" class="control-label col-xs-2">Payment Type</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="paymentType" name="paymentType">
                <option value="0">Choose One</option>
            @foreach ($paymentType as $key => $val)
                <option value="{!! $key !!}">{!! $val->name !!}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="control-label col-xs-2">Status</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="status" name="status">
                <option value="">Please Choose</option>
            @foreach (App\Models\Transaction::$_status as $key => $status)
                <option value="{!! $key !!}">{!! $status !!}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="remarks" class="control-label col-xs-2">Remarks</label>
        <div class="col-xs-4">
            <textarea type="text" rows="2" name="remarks" id="remarks" class="form-control input-sm"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addMember">Add Transaction</button>
        </div>
    </div>
</form>

@endif

<script type="text/javascript">
$(function() {

    $('#frmTxn').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove',
        },
        fields: {
            amount: {
                validators: {
                    notEmpty: {
                        message: 'Amount is required'
                    }
                }
            }
        }
    });
    $('#paymentMode').change(function() {
        var modeId = $(this).val();
        $('#paymentType option').hide();
        $("#paymentType option:selected").prop("selected", false);
        $('#paymentType option:first').show().attr('selected','selected');

        $('#paymentType option').each(function () {
            if ($(this).data('modeid') == modeId) {
                $(this).show();
            }
        });
    });

});
</script>
@stop