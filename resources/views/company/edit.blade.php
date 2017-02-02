@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
<h3 class="page-header">Update Company Detail</h3>

@if (count($brand))
    {!! Form::model($brand,['method' => 'PATCH','route'=>['company.update',$brand->id], 'class'=>'form-horizontal', 'id'=>'frmBrand']) !!}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">Name</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="name" placeholder="" class="form-control input-sm" value="{!! $brand->name !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Company Code</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="companyCode" placeholder="" class="form-control input-sm" value="{!! $brand->company_code !!}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label">Description</label>
        <div class="col-xs-5">
            <textarea name="description" id="description" placeholder="" rows="2" class="form-control input-sm">{!! $brand->description !!}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-xs-2 control-label">Address</label>
        <div class="col-xs-4">
            <input type="text" name="address" id="address" placeholder="i.e. District 2 Riverside Drive" class="form-control input-sm" value="{!!$brand->address!!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="city" class="col-xs-2 control-label">City</label>
        <div class="col-xs-4">
            <input type="text" name="city" id="city" placeholder="i.e. Los Angeles" class="form-control input-sm" value="{!!$brand->city!!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-xs-2 control-label">State/Province</label>
        <div class="col-xs-4">
            <input type="text" name="state" id="state" placeholder="i.e. California" class="form-control input-sm" value="{!!$brand->state!!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="country" class="col-xs-2 control-label">Country</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="countryId" name="countryId">
                <option value="">Please Choose</option>
    @if (count($countries))
        @foreach ($countries as $val)
                <option value="{!!$val->id!!}" {!! ($val->id == $brand->country_id) ? 'selected="selected"' : '' !!}>{!!$val->name!!}</option>
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
                <input type="checkbox" name="isActivated" id="isActivated" value="Y"
                       data-size="small" checked="checked" data-on-text="YES" data-off-text="NO"
                       {!! $brand->is_active == 'Y' ? 'checked="checked"' : '' !!}>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-link" href="{{route('company.index')}}">Cancel</a>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-xs-7" style="padding: 20px 0">
        <div class="pull-left">
            Created: {{ date("F j, Y, g:i a", strtotime($brand->created_at)) }} <br />
            Created by: {{ $brand->created_by }}
        </div>
        <div class="pull-right">
            Updated: {{ date("F j, Y, g:i a", strtotime($brand->updated_at)) }} <br />
            Last updated by: {{ $brand->updated_by }}
        </div>
        <div class="clearfix"></div>
    </div>
@else
    Company doesn't exist!
@endif
</div>
</div>
</div>
<script type="text/javascript">
$(function () {

});
</script>
@stop
