@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Product</h3>
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

<form method="POST" action="{!! route('product.index') !!}" name="frmProduct" class="form-horizontal" id="frmProduct">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="name" placeholder="" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Description</label>
        <div class="col-xs-5">
            <textarea name="description" id="description" placeholder="" rows="2" class="form-control input-sm"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">SKU No</label>
        <div class="col-xs-5">
            <input type="text" name="skuNo" id="skuNo" placeholder="" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Quantity</label>
        <div class="col-xs-5">
            <input type="text" name="quantity" id="quantity" placeholder="" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="branchId" class="control-label col-xs-2">Branch</label>
        <div class="col-xs-5">
            <select class="form-control input-sm col-xs-4" id="branchId" name="branchId">
                <option value="">Please Choose</option>
                <option>1</option>
            </select>
        </div>
    </div>
    <div class="form-group form-inline">
        <label for="isActivated" class="col-xs-2 control-label">Activated</label>
        <div class="checkbox col-xs-2">
            <label>
                <input type="checkbox" name="isActivated" id="isActivated" value="Y" data-size="small" checked="checked" data-on-text="YES" data-off-text="NO">
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addContact">Add Product</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$(function() {
    $("[name='isActivated']").bootstrapSwitch();
    $('#frmProduct').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove',
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            }
        }
    });

});
</script>
@stop