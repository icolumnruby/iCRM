@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Transaction</h3>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (count($contact))
<form method="POST" action="{{route('transaction.index')}}" name="frmContact" class="form-horizontal" id="frmContact">
    {{ csrf_field() }}
    <div class="form-group">
        <label class="col-xs-2 control-label">Contact ID</label>
        <div class="col-xs-5">
            <p class="form-control-static">{{ $contact->id }}</p>
            <input type="hidden" name="contactId" id="contactId" value="{{ $contact->id }}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Product</label>
        <div class="col-xs-5">
            <input type="text" name="autocomplete" id="autocomplete" placeholder="Key in product name" class="form-control input-sm" />
            <input type="hidden" name="productId" id="productId" />
        </div>
    </div>
    <div class="form-group">
        <label for="amount" class="control-label col-xs-2">Amount (Incl tax)</label>
        <div class="col-xs-5">
            <input type="text" name="amount" id="amount" placeholder="i.e. 800.75" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="paymentMode" class="control-label col-xs-2">Payment Mode</label>
        <div class="col-xs-5">
            <select class="form-control input-sm col-xs-4" id="paymentMode" name="paymentMode">
                <option value="">Please Choose</option>
            @foreach (App\Models\Transaction::$_paymentMode as $key => $mode)
                <option value="{{ $key }}">{{ $mode }}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="paymentType" class="control-label col-xs-2">Payment Type</label>
        <div class="col-xs-5">
            <select class="form-control input-sm col-xs-4" id="paymentType" name="paymentType">
                <option value="" class="defaultVal">Please Choose</option>
            @foreach (App\Models\Transaction::$_paymentType as $modeId => $types)
                @foreach ($types as $key => $type)
                <option value="{{ $key }}" data-modeid="{{ $modeId }}" style="display:none">{{ $type }}</option>
                @endforeach
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="control-label col-xs-2">Status</label>
        <div class="col-xs-5">
            <select class="form-control input-sm col-xs-4" id="status" name="status">
                <option value="">Please Choose</option>
            @foreach (App\Models\Transaction::$_status as $key => $status)
                <option value="{{ $key }}">{{ $status }}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="remarks" class="control-label col-xs-2">Remarks</label>
        <div class="col-xs-5">
            <textarea type="text" rows="2" name="remarks" id="remarks" class="form-control input-sm"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addContact">Add Transaction</button>
        </div>
    </div>
</form>

@endif

<script type="text/javascript">
$(function() {
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

    $('#frmContact').formValidation({
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