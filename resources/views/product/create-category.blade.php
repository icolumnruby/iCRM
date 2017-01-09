@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Product Category</h3>
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

@if (count($user))
<form method="POST" action="/product/category" name="frmProdCategory" class="form-horizontal" id="frmContact">
    {{ csrf_field() }}
    <input type="hidden" name="companyId" id="companyId" value="{{ $user->company_id }}" />
    <div class="form-group">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="name" placeholder="Enter category name" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="control-label col-xs-2">Description</label>
        <div class="col-xs-5">
            <textarea type="text" rows="2" name="description" id="description" class="form-control input-sm"></textarea>
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
            <button type="submit" class="btn btn-primary" name="addContact">Add Category</button>
        </div>
    </div>
</form>

@endif

<script type="text/javascript">
$(function() {
    $("[name='isActivated']").bootstrapSwitch();

    $('#frmProdCategory').formValidation({
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

});
</script>
@stop