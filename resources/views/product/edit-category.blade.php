@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
<h3 class="page-header">Update Product Category</h3>

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

@if (count($productCat))
    {!! Form::model($productCat,['method' => 'PATCH','route'=>['product.category.update',$productCat->id], 'class'=>'form-horizontal', 'id'=>'frmProdCat']) !!}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="col-xs-2 control-label">ID</label>
        <div class="col-xs-5">
            <p class="form-control-static">{!! $productCat->id !!}</p>
            <input type="hidden" name="productCategoryId" id="productCategoryId" value="{!! $productCat->id !!}" />
        </div>
    </div>
    <div class="form-group">
        <label for="amount" class="control-label col-xs-2">Name</label>
        <div class="col-xs-5">
            <input type="text" name="name" id="name" value="{!! $productCat->name !!}" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="remarks" class="control-label col-xs-2">Description</label>
        <div class="col-xs-5">
            <textarea type="text" rows="2" name="description" id="description" class="form-control input-sm">{!! $productCat->description !!}</textarea>
        </div>
    </div>
    <div class="form-group form-inline">
        <label for="isActivated" class="col-xs-2 control-label">Activated</label>
        <div class="checkbox col-xs-2">
            <label>
                <input type="checkbox" name="isActivated" id="isActivated" data-size="small" value="Y" {!! $productCat->is_activated == 'Y' ? 'checked="checked"' : '' !!} data-on-text="YES" data-off-text="NO">
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-link" href="{{route('product.category.index')}}">Cancel</a>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="col-xs-7" style="padding: 20px 0">
        <div class="pull-left">
            Created: {{ date("F j, Y, g:i a", strtotime($productCat->created_at)) }} <br />
            Created by: {{ $productCat->created_by }}
        </div>
        <div class="pull-right">
            Updated: {{ date("F j, Y, g:i a", strtotime($productCat->updated_at)) }} <br />
            Last updated by: {{ $productCat->updated_by }}
        </div>
        <div class="clearfix"></div>
    </div>
@else
    Product Category doesn't exist!
@endif
</div>
</div>
</div>
<script type="text/javascript">
$(function () {
    $("[name='isActivated']").bootstrapSwitch();
    $("[name='isActivated']").on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            $(this).attr('checked', 'checked');
        } else {
            $(this).attr('checked', false);
        }
    });

    $('#frmProdCat').formValidation({
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