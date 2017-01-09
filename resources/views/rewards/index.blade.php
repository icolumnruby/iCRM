@extends('layouts/admin')

@section('content')
<h3 class="page-header">Rewards List</h3>

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {!! Session::get('flash_message') !!}
</div>
@endif

@if (count($rewards))

<form class="form-inline pull-right" style="padding-bottom: 10px;">
    <input class="form-control input-sm" type="text" placeholder="Search">
    <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    <a href="{{route('rewards.create')}}" class="btn btn-success btn-sm">Create New</a>
    <div class="clearfix"></div>
</form>

<table class="table table-striped table-condensed table-hover" id="tblRewardsList">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Points</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Daily Limit</th>
        <th>Monthly Limit</th>
        <th>Member Limit</th>
        <th width="7%" colspan="4">Actions</th>
    </tr>
    @foreach ($rewards as $val)
    <tr>
        <td>{!! $val->id !!}</td>
        <td>{!! $val->name !!}</td>
        <td>{!! $val->quantity !!}</td>
        <td>{!! $val->points !!}</td>
        <td>{!! $val->start_date != '0000-00-00 00:00:00' ? date_format(new DateTime($val->start_date), 'Y-m-d H:i:s') : '' !!}</td>
        <td>{!! $val->end_date != '0000-00-00 00:00:00' ? date_format(new DateTime($val->end_date), 'Y-m-d H:i:s') : '' !!}</td>
        <td>{!! $val->daily_limit !!}</td>
        <td>{!! $val->monthly_limit !!}</td>
        <td>{!! $val->member_limit !!}</td>
        <td><a href="{!! route('rewards.show', $val->id)!!}" class="btn btn-primary btn-xs">View</a></td>
        <td><a href="{!! route('rewards.edit', $val->id) !!}" class="btn btn-warning btn-xs">Edit</a></td>
        <td>
            <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
               data-form="#frmDelete{!! $val->id !!}" data-title="Delete Brand"
               data-message="Are you sure you want to delete this brand with ID {!! $val->id !!}?">
                Delete
            </a>
            {!! Form::open(['method' => 'DELETE', 'route'=>['rewards.destroy', $val->id],
            'id' => 'frmDelete' . $val->id]) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $rewards->links() !!}
@else
    No Rewards found!
@endif

<!-- Include the dialog view from "views/dialogbox" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
    $(function () {
        $('#tblRewardsList').on('click', '#btnDelete', function (e) {
            e.preventDefault();
        });
    });
</script>
@stop