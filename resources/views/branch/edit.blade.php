@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
<h3 class="page-header">Update Branch</h3>

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

@if (count($branch))
    {!! Form::model($branch,['method' => 'PATCH','route'=>['branch.update',$branch->id], 'class'=>'form-horizontal']) !!}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">ID</label>
        <div class="col-xs-5">
            <p class="form-control-static">{!! $branch->id !!}</p>
            <input type="hidden" name="branchId" id="branchId" value="{!! $branch->id !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="name" placeholder="" class="form-control input-sm" value="{!! $branch->name !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Address</label>
        <div class="col-xs-5">
            <input type="text" name="address" id="address" placeholder="" class="form-control input-sm" value="{!! $branch->address !!}" />
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
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-link" href="{{route('branch.index')}}">Cancel</a>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-xs-7" style="padding: 20px 0">
        <div class="pull-left">
            Created: {{ date("F j, Y, g:i a", strtotime($branch->created_at)) }} <br />
            Created by: {{ $branch->created_by }}
        </div>
        <div class="pull-right">
            Updated: {{ date("F j, Y, g:i a", strtotime($branch->updated_at)) }} <br />
            Last updated by: {{ $branch->updated_by }}
        </div>
        <div class="clearfix"></div>
    </div>
@else
    Branch doesn't exist!
@endif
</div>
</div>
</div>
<script type="text/javascript">
$(function () {
    $("[name='isActivated']").bootstrapSwitch();
    $('#frmContact').formValidation({
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
            brandId: {
                validators: {
                    notEmpty: {
                        message: 'Branch is required'
                    }
                }
            }
        }
    });

});
</script>
@stop