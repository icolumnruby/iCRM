@extends('layouts/admin')

@section('content')

<h3 class="page-header">Create PassSlot Template</h3>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {!! Session::get('flash_message') !!}
    </div>
@endif
@if(Session::has('error_message'))
<div class="alert alert-danger">
    {!! Session::get('error_message') !!}
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

<form method="POST" action="{!! url('company/save-pass-template') !!}" name="frmPassTemplate" class="form-horizontal" id="frmPassTemplate">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $loggedIn->company_id !!}" />
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
        <label class="col-xs-2 control-label">Logo Text</label>
        <div class="col-xs-5">
            <input type="text" name="logoText" id="logoText" placeholder="" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Foreground Color</label>
        <div class="col-xs-5">
            <input type="text" name="foregroundColor" id="foregroundColor" placeholder="" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Background Color</label>
        <div class="col-xs-5">
            <input type="text" name="backgroundColor" id="backgroundColor" placeholder="" class="form-control input-sm" />
        </div>
    </div>


    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addContact">Create Template</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$(function() {
    $("[name='isActivated']").bootstrapSwitch();
    $('#frmPassTemplate').formValidation({
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