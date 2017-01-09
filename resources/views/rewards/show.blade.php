@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Rewards Detail</h3>
    @if (count($rewards))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $rewards->id !!}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{!! $rewards->name !!}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{!! $rewards->description !!}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{!! $rewards->quantity !!}</td>
            </tr>
            <tr>
                <th>Points</th>
                <td>{!! $rewards->points !!}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{!! $rewards->start_date != '0000-00-00 00:00:00' ? date_format(new DateTime($rewards->start_date), 'Y-m-d H:i:s') : '' !!}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{!! $rewards->end_date != '0000-00-00 00:00:00' ? date_format(new DateTime($rewards->end_date), 'Y-m-d H:i:s') : '' !!}</td>
            </tr>
            <tr>
                <th>Daily Limit</th>
                <td>{!! $rewards->daily_limit !!}</td>
            </tr>
            <tr>
                <th>Monthly Limit</th>
                <td>{!! $rewards->monthly_limit !!}</td>
            </tr>
            <tr>
                <th>Limit per Member</th>
                <td>{!! $rewards->member_limit !!}</td>
            </tr>
            <tr>
                <th>Activated</th>
                <td>{!! $rewards->is_active == 'Y' ? 'Yes' : 'No' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('rewards.edit',$rewards->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
            <div class="pull-left">
                Created: {{ date("F j, Y, g:i a", strtotime($rewards->created_at)) }} <br />
                Created by: {{ $rewards->created_by }}
            </div>
            <div class="pull-right">
                Updated: {{ date("F j, Y, g:i a", strtotime($rewards->updated_at)) }} <br />
                Last updated by: {{ $rewards->updated_by }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    @endif
@stop