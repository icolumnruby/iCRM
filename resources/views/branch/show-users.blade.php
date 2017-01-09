@extends('layouts/admin')

@section('content')
<h3 class="page-header">Branch Users List</h3>

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {!! Session::get('flash_message') !!}
</div>
@endif

@if (count($users))

<form class="form-inline pull-right" style="padding-bottom: 10px;">
    <input class="form-control input-sm" type="text" placeholder="Search">
    <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    <div class="clearfix"></div>
</form>

<table class="table table-striped table-condensed table-hover" id="tblTxnList">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Activated</th>
        <th width="7%" colspan="4">Actions</th>
    </tr>
    @foreach ($users as $val)
    <tr>
        <td>{!! $val->id !!}</td>
        <td>{!! $val->name or ''!!}</td>
        <td>{!! $val->email or '' !!}</td>
        <td>{!! $val->type == 2 ? 'Manager' : 'Staff' !!}</td>
        <td>{!! $val->is_active == 'Y' ? 'Yes' : 'No' !!}</td>
        <td><a href="{!! route('branch.show', $val->id)!!}" class="btn btn-primary btn-xs">View</a></td>
        <td><a href="{!! route('branch.edit', $val->id) !!}" class="btn btn-warning btn-xs">Edit</a></td>
        <td>
            <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
               data-form="#frmDelete{!! $val->id !!}" data-title="Delete Branch"
               data-message="Are you sure you want to delete this branch with ID {!! $val->id !!}?">
                Delete
            </a>
            {!! Form::open(['method' => 'DELETE', 'route'=>['branch.destroy', $val->id],
            'id' => 'frmDelete' . $val->id]) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $users->links() !!}
@else
    No User(s) found!
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