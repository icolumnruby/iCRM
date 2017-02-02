@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Merchant Sign Up</div>
                <div class="panel-body">
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

                    @if (!session('registered'))
                    <form class="form-horizontal" id="frmRegisterMerchant" role="form" method="POST" action="{!! url('/register') !!}">
                        {!! csrf_field() !!}

                        <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                            <label class="col-md-4 control-label">Brand Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="brand" value="{!! old('brand') !!}">

                                @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('brand') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                            <label class="col-md-4 control-label">Company</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company" value="{!! old('company') !!}">

                                @if ($errors->has('company'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('company') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{!! $errors->has('fullname') ? ' has-error' : '' !!}">
                            <label class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="fullname" value="{!! old('fullname') !!}">

                                @if ($errors->has('fullname'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('fullname') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{!! old('email') !!}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('email') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('mobile') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Mobile No</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" value="{!! old('mobile') !!}">

                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('mobile') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{!! $errors->has('comments') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Comments</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="comments">{!! old('comments') !!}</textarea>

                                @if ($errors->has('comments'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('comments') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                {!! captcha_html($attributes) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    <!-- end if, registered -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {

    $('#frmRegisterMerchant').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove'
        },
        fields: {
            code: {
                validators: {
                    notEmpty: {
                        message: 'Company Code is required'
                    }
                }
            },
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
            },
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'Mobile No is required'
                    }
                }
            }
        }
    })
    .on('err.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }
    })
    .on('success.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }
    });

});
</script>
@endsection
