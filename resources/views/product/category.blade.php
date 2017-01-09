@extends('layouts/admin')

@section('content')
<h3 class="page-header">Category List</h3>

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {!! Session::get('flash_message') !!}
</div>
@endif

@if (count($categories))

<form class="form-inline pull-right" style="padding-bottom: 10px;">
    <input class="form-control input-sm" type="text" placeholder="Search">
    <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    <a href="{{route('product.category.create')}}" class="btn btn-success btn-sm">Create New</a>
    <div class="clearfix"></div>
</form>

<table class="table table-striped table-condensed table-hover" id="tblCatList">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Is Active</th>
        <th width="7%" colspan="4">Actions</th>
    </tr>
    @foreach ($categories as $val)
    <tr>
        <td>{!! $val->id !!}</td>
        <td>{!! $val->name !!}</td>
        <td>{!! $val->is_activated !!}</td>
        <td><a href="{!! route('product.category.show', $val->id)!!}" class="btn btn-primary btn-xs">View</a></td>
        <td><a href="{!! route('product.category.edit', $val->id) !!}" class="btn btn-warning btn-xs">Edit</a></td>
        <td>
            <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
               data-form="#frmDelete{!! $val->id !!}" data-title="Delete Category"
               data-message="Are you sure you want to delete this category with ID {!! $val->id !!}?">
                Delete
            </a>
            {!! Form::open(['method' => 'DELETE', 'route'=>['product.category.destroy', $val->id],
            'id' => 'frmDelete' . $val->id]) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $categories->links() !!}
@else
    No Categories found!
@endif

<!-- Include the dialog view from "views/dialogbox" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
    $(function () {
        $('#tblCatList').on('click', '#btnDelete', function (e) {
            e.preventDefault();
        });
    });
</script>
@stop