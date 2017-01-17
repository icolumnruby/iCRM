@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Company</h3>
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

<form method="POST" action="{!! route('company.index') !!}" name="frmBrand" class="form-horizontal" id="frmBrand">
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
        <label for="state" class="col-xs-2 control-label">Address</label>
        <div class="col-xs-4">
            <input type="text" name="address" id="address" placeholder="i.e. District 2 Riverside Drive" class="form-control input-sm" value="{!!old('address')!!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="city" class="col-xs-2 control-label">City</label>
        <div class="col-xs-4">
            <input type="text" name="city" id="city" placeholder="i.e. Los Angeles" class="form-control input-sm" value="{!!old('city')!!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-xs-2 control-label">State/Province</label>
        <div class="col-xs-4">
            <input type="text" name="state" id="state" placeholder="i.e. California" class="form-control input-sm" value="{!!old('state')!!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="country" class="col-xs-2 control-label">Country</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="countryId" name="countryId">
                <option value="">Please Choose</option>
    @if (count($countries))
        @foreach ($countries as $val)
                <option value="{!!$val->id!!}" {!! ($val->name == 'Singapore') ? 'selected="selected"' : '' !!}>{!!$val->name!!}</option>
        @endforeach
    @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="postalCode" class="col-xs-2 control-label">Postal Code</label>
        <div class="col-xs-4">
            <input type="text" name="postalCode" id="postalCode" placeholder="i.e. 445701" class="form-control input-sm" value="{!!old('postalCode')!!}" />
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
    <br />
    <div class="form-group">
        <label class="col-xs-2 control-label"><i>Pass Wallet Detail</i></label>
    </div>
    <br />
    <div class="form-group">
        <label class="col-xs-2 control-label">Template ID</label>
        <div class="col-xs-5">
            <input type="text" name="templateId" id="templateId" placeholder="" class="form-control input-sm" />
            <input type="hidden" name="passTypeId" value="pass.slot.storecard" />
            <input type="hidden" name="passStyle" value="storecard" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addContact">Add Company</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$(function() {
    $("[name='isActivated']").bootstrapSwitch();
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

});
</script>
@stop