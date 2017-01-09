@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Branch Detail:</h3>
    @if (count($productCat))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $productCat->id !!}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{!! $productCat->name !!}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{!! $productCat->description !!}</td>
            </tr>
            <tr>
                <th>Activated</th>
                <td>{!! $productCat->is_activated == 'Y' ? 'Yes' : 'No' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('product.category.edit',$productCat->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
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
    </div>


    @endif
@stop