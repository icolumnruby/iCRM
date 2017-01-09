@extends('layouts/admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <h2 class="page-header">Member Detail</h2><br />
            <h4><strong>Loyalty Points:</strong> {!! $totalPoints !!}</h4><br />

    @if (count($member))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $member->id !!}</td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td>{!! App\Models\Member::$_salutation[$member->salutation] !!} {!! ucfirst($member->lastname) !!}, {!! ucfirst($member->firstname) !!} {!! ucfirst($member->middlename) !!}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{!! App\Models\Member::$_gender[$member->gender] !!}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{!! $member->email !!}</td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>{!! $member->mobile_country_code . $member->mobile !!}</td>
            </tr>
            <tr>
                <th>NRIC</th>
                <td>{!! $member->nric !!}</td>
            </tr>
            <tr>
                <th>Birthdate</th>
                <td>{!! $member->birthdate !!}</td>
            </tr>
            <tr>
                <th>Nationality</th>
                <td>{!! $member->nationality !!}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{!! $member->address !!}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{!! $member->city !!}</td>
            </tr>
            <tr>
                <th>State</th>
                <td>{!! $member->state !!}</td>
            </tr>
            <tr>
                <th>Country</th>
                <td>{!! $member->country !!}</td>
            </tr>
            <!--tr>
                <th>Is Member</th>
                <td>{!! $member->is_member ? 'Yes' : 'No' !!}</td>
            </tr-->
            <tr>
                <th>Member Type</th>
                <td>{!! $member->member_type_id ? App\Models\Member::$_memberType[$member->member_type_id] : '' !!}</td>
            </tr>
        </table>

        <div class="col-md-5">
            Created: {!! date("F j, Y, g:i a", strtotime($member->created_at)) !!} <br />
            Created by: {!! $member->created_by !!}
        </div>
        <div class="col-md-5 pull-right">
            Updated: {!! date("F j, Y, g:i a", strtotime($member->updated_at)) !!} <br />
            Last updated by: {!! $member->updated_by !!}
        </div>
        <div class="clearfix"></div>
        <br />
        <p class=""><a href="{!!route('member.edit',$member->id)!!}" class="btn btn-primary btn-m">Edit</a>
        <a href="{!! url('transaction/create', $member->id) !!}" class="btn btn-primary btn-m">Add Transaction</a>
        <a href="{!! url('member/add-points',$member->id) !!}" class="btn btn-primary btn-m">Update Points</a>
        <a href="{!! url('rewards/items',$member->id) !!}" class="btn btn-primary btn-m">Rewards</a>
        </p>
    </div>
    @endif


        </div>
    </div>
</div>


@stop