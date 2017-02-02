@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Merchant Detail</div>
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

                    <form class="form-horizontal" id="frmRegisterMerchant" role="form" method="POST" action="{!! url('/register') !!}">
                        {!! csrf_field() !!}

                        <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                            <label class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="iColumn Pte Ltd">
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('fullname') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="Ruby Lamadora">
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="ruby@icolumn.com">
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group{!! $errors->has('password_confirmation') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group{!! $errors->has('mobile') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Mobile No</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" value="98765432">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6">
                                <select class="form-control input-sm col-xs-4" id="country_id" name="country_id">
                                    <option value="">Singapore</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{!! $errors->has('mobile') ? ' has-error' : '' !!} required">
                            <label class="col-md-4 control-label">Mobile No</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" value="98765432">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Approve
                                </button>
                            </div>
                        </div>
                    </form>
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
