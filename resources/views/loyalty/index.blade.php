@extends('layouts/admin')

@section('content')
<h3 class="page-header">Loyalty Config List</h3>

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {!! Session::get('flash_message') !!}
</div>
@endif

@if (count($loyalty))

<form class="form-inline pull-right" style="padding-bottom: 10px;">
    <input class="form-control input-sm" type="text" placeholder="Search">
    <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    <a href="{{route('loyalty.create')}}" class="btn btn-success btn-sm">Create New</a>
    <div class="clearfix"></div>
</form>

<table class="table table-striped table-condensed table-hover" id="tblLoyaltyList">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Member Type</th>
        <th>Action</th>
        <th>Spending Amount ($)</th>
        <th>Points</th>
        <th>Expiry</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th width="7%" colspan="4">Actions</th>
    </tr>
    @foreach ($loyalty as $val)
    <tr>
        <td>{!! $val->id !!}</td>
        <td>{!! $val->name !!}</td>
        <td>{!! App\Models\Member::$_memberType[$val->member_type_id] !!}</td>
        <td>{!! App\Models\LoyaltyConfig::$_action[$val->action_id] !!}</td>
        <td>{!! $val->value !!}</td>
        <td>{!! $val->points !!}</td>
        <td>{!! ($val->expiry && $val->expiry != '0000-00-00 00:00:00') ? date_format(new DateTime($val->expiry), 'Y-m-d H:i:s') : '' !!}</td>
        <td>{!! ($val->start_date && $val->start_date != '0000-00-00 00:00:00') ? date_format(new DateTime($val->start_date), 'Y-m-d H:i:s') : '' !!}</td>
        <td>{!! ($val->end_date && $val->end_date != '0000-00-00 00:00:00') ? date_format(new DateTime($val->end_date), 'Y-m-d H:i:s') : '' !!}</td>
        <td><a href="{!! route('loyalty.show', $val->id)!!}" class="btn btn-primary btn-xs">View</a></td>
        <td><a href="{!! route('loyalty.edit', $val->id) !!}" class="btn btn-warning btn-xs">Edit</a></td>
        <td>
            <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
               data-form="#frmDelete{!! $val->id !!}" data-title="Delete Brand"
               data-message="Are you sure you want to delete this brand with ID {!! $val->id !!}?">
                Delete
            </a>
            {!! Form::open(['method' => 'DELETE', 'route'=>['loyalty.destroy', $val->id],
            'id' => 'frmDelete' . $val->id]) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $loyalty->links() !!}
@else
    No Loyalty settings found!
@endif

<!-- Include the dialog view from "views/dialogbox" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
    $(function () {
        $('#tblLoyaltyList').on('click', '#btnDelete', function (e) {
            e.preventDefault();
        });
    });
</script>
@stop