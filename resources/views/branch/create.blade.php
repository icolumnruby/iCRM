@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Branch</h3>
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

<form method="POST" action="{!! route('branch.index') !!}" name="frmBranch" class="form-horizontal" id="frmBranch">
    {!! csrf_field() !!}
    <input type="hidden" name="company_id" value="{!! $user->company_id !!}" />
    <div class="form-group required">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="name" placeholder="" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Address</label>
        <div class="col-xs-5">
            <input type="text" name="address" id="address" placeholder="" class="form-control input-sm" />
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
            <button type="submit" class="btn btn-primary" name="addContact">Add Branch</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$(function() {
    $("[name='isActivated']").bootstrapSwitch();
    $('#frmBranch').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
        }
    });

});
</script>
@stop