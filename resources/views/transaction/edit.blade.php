@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
<h3 class="page-header">Update Transaction</h3>

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

@if (count($txn))
    {!! Form::model($txn,['method' => 'PATCH','route'=>['transaction.update',$txn->id], 'class'=>'form-horizontal']) !!}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">Member ID</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! $txn->member->id !!}</p>
            <input type="hidden" name="memberId" id="memberId" value="{!! $txn->member->id !!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="txnNo" class="control-label col-xs-2">Transaction No</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! $txn->transaction_no !!}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Product Category</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="productCategoryId" name="productCategoryId">
                <option value="">Please Choose</option>
        @if (count($categories))
            @foreach ($categories as $val)
                <option value="{{ $val->id }}" {!! ($val->id == $txn->product_category_id) ? 'selected="selected"' : '' !!}>{{ $val->name }}</option>
            @endforeach
        @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="amount" class="control-label col-xs-2">Amount (Incl tax)</label>
        <div class="col-xs-4">
            <input type="text" name="amount" id="amount" value="{!! $txn->amount !!}" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="paymentType" class="control-label col-xs-2">Payment Type</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="paymentType" name="paymentType">
                <option value="0">Choose One</option>
            @foreach ($paymentType as $val)
            <option value="{!! $val->id !!}"
                    {!! $val->id == $txn->payment_type ? 'selected="selected"' : '' !!}>{!! $val->name !!}</option>
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
                <option value="{!! $key !!}" {!! $key == $txn->status ? 'selected="selected"' : '' !!}>{!! $status !!}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="remarks" class="control-label col-xs-2">Remarks</label>
        <div class="col-xs-4">
            <textarea type="text" rows="2" name="remarks" id="remarks" class="form-control input-sm">{!! $txn->remarks !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-link" href="{{route('transaction.index')}}">Cancel</a>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-xs-7" style="padding: 20px 0">
        <div class="pull-left">
            Created: {{ date("F j, Y, g:i a", strtotime($txn->created_at)) }} <br />
            Created by: {{ $txn->created_by }}
        </div>
        <div class="pull-right">
            Updated: {{ date("F j, Y, g:i a", strtotime($txn->updated_at)) }} <br />
            Last updated by: {{ $txn->updated_by }}
        </div>
        <div class="clearfix"></div>
    </div>
@else
    Transaction doesn't exist!
@endif
</div>
</div>
</div>
<script type="text/javascript">
$(function () {
    $('#autocomplete').autocomplete({
        source: '/transaction/searchProduct',
        dataType: 'jsonp',
        minLength: 2,
        select: function (event, ui) {
            $('#productId').val(ui.item.id);
            $('#autocomplete').val(ui.item.name);
            return false;
        }
    }).autocomplete( "instance" )._renderItem = function(ul, item) {
        ul.attr('class', 'productsAjax');
        return $( "<li>" )
          .append(item.name)
          .appendTo(ul);
    };

    $('#frmMember').formValidation({
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

    var modeId = $('#paymentMode').val();

    $('#paymentType option').hide();
    $("#paymentType option:selected").prop("selected", false);
    $('#paymentType option:first').show().attr('selected', 'selected');

    $('#paymentType option').each(function () {
        if ($(this).data('modeid') == modeId) {
            $(this).show();
            $(this).attr('selected', 'selected');
        }
    });

});
</script>
@stop