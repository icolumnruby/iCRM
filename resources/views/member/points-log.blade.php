@extends('layouts/admin')

@section('content')

<h2 class="page-header">Points Logs</h2>

    @if(Session::has('flash_message'))
    <div class="alert alert-success">
        {!! Session::get('flash_message') !!}
    </div>
    @endif

    @if (count($memberPoints))
    <table class="table table-striped table-condensed table-hover" id="tblMemberList">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Transaction</th>
            <th>Earned Points</th>
            <th>Redeemed Points</th>
        </tr>
    @foreach ($memberPoints as $val)
        <tr>
            <td>{!! $val->id !!}</td>
            <td>
                <a href="{!!url('member',$val->memberId)!!}">
                    {!! ucfirst($val->lastname) !!}, {!! ucfirst($val->firstname) !!}
                </a>
            </td>
            <td>{!! App\Models\LoyaltyConfig::$_action[$val->action_id] !!}</td>
            <td>{!! $val->type == '+' ? $val->points : '' !!}</td>
            <td>{!! $val->type == '-' ? $val->points : '' !!}</td>
        </tr>
     @endforeach
     </table>
    <br />
    <div class="pull-left">
        {!! $memberPoints->links() !!}
    </div>
    <div class="pull-left" style="margin: 27px">
        {!! 'displaying ' . $memberPoints->count() . ' out of ' . $memberPoints->total() . ' results' !!}
    </div>
    {!! $memberPoints->links() !!}
    @else
        No points logs found!
    @endif
@stop