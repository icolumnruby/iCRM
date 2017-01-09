@extends('layouts/admin')

@section('content')
<h3 class="page-header">Company List</h3>

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {!! Session::get('flash_message') !!}
</div>
@endif

@if (count($brands))

<form class="form-inline pull-right" style="padding-bottom: 10px;">
    <input class="form-control input-sm" type="text" placeholder="Search">
    <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    <div class="clearfix"></div>
</form>

<table class="table table-striped table-condensed table-hover" id="tblTxnList">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Company Code</th>
        <th>Description</th>
        <th width="7%" colspan="4">Actions</th>
    </tr>
    @foreach ($brands as $brand)
    <tr>
        <td>{!! $brand->id !!}</td>
        <td>{!! $brand->name !!}</td>
        <td>{!! $brand->company_code !!}</td>
        <td>{!! $brand->description !!}</td>
        <td><a href="{!! route('company.show', $brand->id)!!}" class="btn btn-primary btn-xs">View</a></td>
        <td><a href="{!! route('company.edit', $brand->id) !!}" class="btn btn-warning btn-xs">Edit</a></td>
        <td>
            <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
               data-form="#frmDelete{!! $brand->id !!}" data-title="Delete Brand"
               data-message="Are you sure you want to delete this brand with ID {!! $brand->id !!}?">
                Delete
            </a>
            {!! Form::open(['method' => 'DELETE', 'route'=>['company.destroy', $brand->id],
            'id' => 'frmDelete' . $brand->id]) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $brands->links() !!}
@else
    No Company found!
@endif

<!-- Include the dialog view from "views/dialogbox" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
    $(function () {
        $('#tblTxnList').on('click', '#btnDelete', function (e) {
            e.preventDefault();
        });
    });
</script>
@stop