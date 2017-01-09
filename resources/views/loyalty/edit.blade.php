@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
<h3 class="page-header">Update Loyalty Config</h3>

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

@if (count($loyalty))
    {!! Form::model($loyalty,['method' => 'PATCH','route'=>['loyalty.update',$loyalty->id], 'class'=>'form-horizontal', 'id'=>'frmLoyalty']) !!}
    {!! csrf_field() !!}
    <div class="form-group required">
        <label for="memberType" class="col-xs-2 control-label">Member Type</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="memberTypeId" name="memberTypeId">
                <option value="">Please Choose</option>
        @foreach (App\Models\Member::$_memberType as $key => $val)
                <option value="{!!$key!!}" {!! $key == $loyalty->member_type_id ? 'selected="selected"' : '' !!}>{!!$val!!}</option>
        @endforeach
            </select>
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-4">
            <input type="text" name="name" id="name" placeholder="" class="form-control input-sm" value="{!! $loyalty->name !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Description</label>
        <div class="col-xs-4">
            <textarea name="description" id="description" placeholder="" rows="2" class="form-control input-sm">{!! $loyalty->description !!}</textarea>
        </div>
    </div>
    <div class="form-group required">
        <label for="typeId" class="control-label col-xs-2">Action</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="actionId" name="actionId">
                <option value="">Choose One</option>
            @foreach (App\Models\LoyaltyConfig::$_action as $key => $val)
                <option value="{!! $key !!}" {!! $key == $loyalty->action_id ? 'selected="selected"' : '' !!}>{!! $val !!}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group required">
        <label for="typeId" class="control-label col-xs-2">Action Type</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="actionType" name="actionType">
                <option value="">Choose One</option>
                <option value="+" {!! '+' == $loyalty->type ? 'selected="selected"' : '' !!}>Add</option>
                <option value="-" {!! '-' == $loyalty->type ? 'selected="selected"' : '' !!}>Deduct</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Value</label>
        <div class="col-xs-4">
            <input type="text" name="value" id="value" placeholder="" class="form-control input-sm" value="{!! $loyalty->value !!}" />
        </div>
    </div>
    <div class="form-group required">
        <label class="col-xs-2 control-label">Points</label>
        <div class="col-xs-4">
            <input type="text" name="points" id="points" placeholder="" class="form-control input-sm" value="{!! $loyalty->points !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Points Expiry</label>
        <div class="col-xs-4">
            <input type="date" name="expiry" placeholder="" class="form-control input-sm" min="{!! date('Y-m-d') !!}" value="" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Start Date</label>
        <div class="col-xs-3">
            <div id="datetimepicker1" class="input-group input-append">
                <input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="startDate"></input>
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
                <input data-format="yyyy-MM-dd hh:mm:ss" type="text" class="form-control" name="endDate"></input>
                <span class="input-group-addon add-on">
                    <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group form-inline">
        <label for="isActivated" class="col-xs-2 control-label">Activated</label>
        <div class="checkbox col-xs-2">
            <label>
                <input type="checkbox" name="isActivated" id="isActivated" value="Y"
                       data-size="small" checked="checked" data-on-text="YES" data-off-text="NO"
                       {!! $loyalty->is_active == 'Y' ? 'checked="checked"' : '' !!}>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-link" href="{{route('loyalty.index')}}">Cancel</a>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-xs-7" style="padding: 20px 0">
        <div class="pull-left">
            Created: {{ date("F j, Y, g:i a", strtotime($loyalty->created_at)) }} <br />
            Created by: {{ $loyalty->created_by }}
        </div>
        <div class="pull-right">
            Updated: {{ date("F j, Y, g:i a", strtotime($loyalty->updated_at)) }} <br />
            Last updated by: {{ $loyalty->updated_by }}
        </div>
        <div class="clearfix"></div>
    </div>
@else
    Loyalty Config doesn't exist!
@endif
</div>
</div>
</div>
<script type="text/javascript">
$(function () {
    $("[name='isActivated']").bootstrapSwitch();
    $('#frmLoyalty').formValidation({
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
            actionId: {
                validators: {
                    notEmpty: {
                        message: 'Action is required'
                    }
                }
            },
            points: {
                validators: {
                    notEmpty: {
                        message: 'Points is required'
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

    jQuery('#actionId').change(function() {
        if (jQuery(this).val() != 1) {
            jQuery('#value').attr('disabled', true);
        } else {
            jQuery('#value').attr('disabled', false);
        }
    });


});
</script>
@stop