@extends('layouts/admin')

@section('content')

<h3 class="page-header">Add Member Points</h3>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {!! Session::get('flash_message') !!}
    </div>
@elseif(Session::has('error_message'))
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

@if (count($member))
<form method="POST" action="{!!url('member/save-points')!!}" name="frmAddPoints" class="form-horizontal" id="frmAddPoints">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">Member ID</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! $member->id !!}</p>
            <input type="hidden" name="memberId" id="memberId" value="{!! $member->id !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! $member->lastname .', '. $member->firstname !!}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Member Type</label>
        <div class="col-xs-4">
            <p class="form-control-static">{!! App\Models\Member::$_memberType[$member->member_type_id] !!}</p>
        </div>
    </div>
    <div class="form-group required">
        <label for="paymentType" class="control-label col-xs-2">Action</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="loyaltyConfigId" name="loyaltyConfigId">
                <option value="">Choose One</option>
            @foreach ($loyaltyConfig as $val)
                @if ($val->action_id != 1)
                <option value="{!! $val->id !!}" {!! old('loyaltyConfigId') == $val->id ? 'selected="selected"' : ''  !!}>{!! $val->name . ' (' . $val->type . $val->points . 'pts)' !!}</option>
                @endif
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="remarks" class="control-label col-xs-2">Remarks</label>
        <div class="col-xs-4">
            <textarea type="text" rows="2" name="remarks" id="remarks" class="form-control input-sm">{!! old('remarks') !!}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary" name="addMember">Update Points</button>
        </div>
    </div>
</form>

@endif

<script type="text/javascript">
$(function() {

    $('#frmAddPoints').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove',
        },
        fields: {
            loyaltyConfigId: {
                validators: {
                    notEmpty: {
                        message: 'Action is required'
                    }
                }
            }
        }
    });
    $('#paymentMode').change(function() {
        var modeId = $(this).val();
        $('#paymentType option').hide();
        $("#paymentType option:selected").prop("selected", false);
        $('#paymentType option:first').show().attr('selected','selected');

        $('#paymentType option').each(function () {
            if ($(this).data('modeid') == modeId) {
                $(this).show();
            }
        });
    });

});
</script>
@stop