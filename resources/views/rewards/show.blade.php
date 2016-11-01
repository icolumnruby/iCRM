@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Brand Detail:</h3>
    @if (count($brand))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $brand->id !!}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{!! $brand->name !!}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{!! $brand->description !!}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{!! $brand->category_id !!}</td>
            </tr>
            <tr>
                <th>Activated</th>
                <td>{!! $brand->is_activated == 'Y' ? 'Yes' : 'No' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('brand.edit',$brand->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
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
    </div>


    @endif
@stop