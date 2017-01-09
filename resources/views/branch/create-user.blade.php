@extends('layouts/admin')

@section('content')

@if ($type == 2)
<h3 class="page-header">Add Branch Manager</h3>
@elseif ($type == 3)
<h3 class="page-header">Add Branch Staff</h3>
@endif
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

<form method="POST" action="/branch/create-user" name="frmBranchAdmin" class="form-horizontal" id="frmBranchAdmin">
    {!! csrf_field() !!}
    <input type="hidden" name="company_id" value="{!! $user->company_id !!}" />
    <input type="hidden" name="type" value="{!! $type !!}" />
    <div class="form-group">
        <label class="col-xs-2 control-label">Name</label>

        <div class="col-xs-4">
            <input type="text" class="form-control" name="name" value="{!! old('name') !!}">
        </div>
    </div>
    <div class="form-group required">
        <label for="country" class="col-xs-2 control-label">Branch</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="branch_id" name="branch_id">
                <option value="">Please Choose</option>
                @if (count($branches))
                    @foreach ($branches as $val)
                            <option value="{!!$val->id!!}" {!! ($val->id == old('branch_id')) ? 'selected="selected"' : '' !!}>{!!$val->name!!}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">E-Mail Address</label>

        <div class="col-xs-4">
            <input type="email" class="form-control" name="email" value="{!! old('email') !!}">
        </div>
    </div>

    <div class="form-group required">
        <label class="col-xs-2 control-label">Password</label>

        <div class="col-xs-4">
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Confirm Password</label>

        <div class="col-xs-4">
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>
    <div class="form-group">
        <label for="isActivated" class="col-xs-2 control-label">Activated</label>
        <div class="checkbox col-xs-2">
            <label>
                <input type="checkbox" name="isActivated" id="isActivated" value="Y" data-size="small" checked="checked" data-on-text="YES" data-off-text="NO">
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addContact">Add Branch Admin</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$(function() {
    $("[name='isActivated']").bootstrapSwitch();
    $('#frmBranchAdmin').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
                    email: {
                        message: 'The input is not a valid email address'
                    },
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    }
                }
            },
            branch_id: {
                validators: {
                    notEmpty: {
                        message: 'Branch is required'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    }
                }
            },
            confirm_password: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm must be the same'
                    }
                }
            }
        }
    });

});
</script>
@stop