@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Loyalty Configuration:</h3>
    @if (count($loyalty))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $loyalty->id !!}</td>
            </tr>
            <tr>
                <th>Member Type</th>
                <td>{!! App\Models\Member::$_memberType[$loyalty->member_type_id] !!}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{!! $loyalty->name !!}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{!! $loyalty->description !!}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{!! App\Models\LoyaltyConfig::$_type[$loyalty->type_id] !!}</td>
            </tr>
            <tr>
                <th>Value</th>
                <td>{!! $loyalty->value !!}</td>
            </tr>
            <tr>
                <th>Points</th>
                <td>{!! $loyalty->points !!}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{!! $loyalty->start_date != '0000-00-00 00:00:00' ? date_format(new DateTime($loyalty->start_date), 'Y-m-d H:i:s') : '' !!}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{!! $loyalty->end_date != '0000-00-00 00:00:00' ? date_format(new DateTime($loyalty->end_date), 'Y-m-d H:i:s') : '' !!}</td>
            </tr>
            <tr>
                <th>Activated</th>
                <td>{!! $loyalty->is_active == 'Y' ? 'Yes' : 'No' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('loyalty.edit',$loyalty->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
            <div class="pull-left">
                Created: {{ date("F j, Y, g:i a", strtotime($loyalty->created_at)) }} <br />
                Created by: {{ $loyalty->created_by }}
            </div>
            <div class="pull-right">
                Updated: {{ date("F j, Y, g:i a", strtotime($loyalty->updated_at)) }} <br />
                Last updated by: {{ $loyalty->updated_by }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    @endif
@stop