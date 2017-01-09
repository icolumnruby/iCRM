@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Rewards</h3>
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

<form method="POST" action="{!! route('rewards.index') !!}" name="frmReward" class="form-horizontal" id="frmReward">
    {!! csrf_field() !!}
    <input type="hidden" name="companyId" value="{!! $user->company_id !!}" />
    <div class="form-group required">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-4">
            <input type="text" name="name" id="name" placeholder="" class="form-control input-sm" value="{!! old('name') !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Description</label>
        <div class="col-xs-4">
            <textarea name="description" id="description" placeholder="" rows="2" class="form-control input-sm">{!! old('description') !!}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Quantity</label>
        <div class="col-xs-4">
            <input type="text" name="quantity" id="quantity" placeholder="" class="form-control input-sm" value="{!! old('quantity') !!}" />
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Points</label>
        <div class="col-xs-4">
            <input type="text" name="points" id="points" placeholder="" class="form-control input-sm" value="{!! old('points') !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Start Date</label>
        <div class="col-xs-3">
            <div id="datetimepicker1" class="input-group input-append">
                <input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="startDate" value="{!! old('startDate') !!}"></input>
                <span class="input-group-addon add-on">
                    <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">End Date</label>
        <div class="col-xs-3">
            <div id="datetimepicker2" class="input-group input-append">
                <input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="endDate" value="{!! old('endDate') !!}"></input>
                <span class="input-group-addon add-on">
                    <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Daily Limit</label>
        <div class="col-xs-2">
            <input type="number" name="dailyLimit" id="dailyLimit" placeholder="" class="form-control input-sm" value="{!! old('dailyLimit') !!}" />
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Monthly Limit</label>
        <div class="col-xs-2">
            <input type="number" name="monthlyLimit" id="monthlyLimit" placeholder="" class="form-control input-sm" value="{!! old('monthlyLimit') !!}" />
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Member Limit</label>
        <div class="col-xs-2">
            <input type="number" name="memberLimit" id="memberLimit" placeholder="" class="form-control input-sm" value="{!! old('memberLimit') !!}" />
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
            <button type="submit" class="btn btn-primary" name="addContact">Save</button>
        </div>
    </div>
</form>

<script type="text/javascript">
jQuery(function() {
    jQuery("[name='isActivated']").bootstrapSwitch();
    jQuery('#frmReward').formValidation({
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
            },
            points: {
                validators: {
                    notEmpty: {
                        message: 'Points is required'
                    }
                }
            },
            dailyLimit: {
                validators: {
                    notEmpty: {
                        message: 'Daily Limit is required'
                    }
                }
            },
            monthlyLimit: {
                validators: {
                    notEmpty: {
                        message: 'Monthly Limit is required'
                    }
                }
            },
            memberLimit: {
                validators: {
                    notEmpty: {
                        message: 'Member Limit is required'
                    }
                }
            }
        }
    });

    jQuery('#datetimepicker1, #datetimepicker2').datetimepicker({
        language: 'en',
        format: 'yyyy-MM-dd hh:mm:ss',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    jQuery('#datetimepicker2').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    jQuery("#datetimepicker1").on("dp.change", function (e) {
        jQuery('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    jQuery("#datetimepicker2").on("dp.change", function (e) {
        jQuery('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });


});
</script>
@stop