@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Product Detail:</h3>
    @if (count($product))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $product->id !!}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{!! $product->name !!}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{!! $product->description !!}</td>
            </tr>
            <tr>
                <th>SKU No.</th>
                <td>{!! $product->sku_no !!}</td>
            </tr>
            <tr>
                <th>Branch</th>
                <td>{!! $product->branch_id !!}</td>
            </tr>
            <tr>
                <th>Activated</th>
                <td>{!! $product->is_activated == 'Y' ? 'Yes' : 'No' !!}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{!! $product->status > 0 ? App\Transaction::$_status[$product->status] : '' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('product.edit',$product->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
            <div class="pull-left">
                Created: {{ date("F j, Y, g:i a", strtotime($product->created_at)) }} <br />
                Created by: {{ $product->created_by }}
            </div>
            <div class="pull-right">
                Updated: {{ date("F j, Y, g:i a", strtotime($product->updated_at)) }}
                Last updated by: {{ $product->updated_by }} <br />
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    @endif
@stop