@extends('layouts/admin')
@section('content-theme', 'theme-grey')
@section('content')
@if (count($member))
<div class="section-header row">
  <div class="col m6">
      <h3>Member Details</h3>
      <h5>{!! App\Models\Member::$_salutation[$member->salutation] !!} {!! ucfirst($member->lastname) !!}, {!! ucfirst($member->firstname) !!} {!! ucfirst($member->middlename) !!}</h5>
  </div>
  <div class="col m6">
      <h5><strong>Loyalty Points:</strong> {!! $totalPoints !!}</h5>
  </div>
</div>
<div class="row">
  <div class="col m12">
    <a href="{!!route('member.edit',$member->id)!!}" class="btn btn-primary">Edit</a>
    <a href="{!! url('transaction/create', $member->id) !!}" class="btn btn-primary">Add Transaction</a>
    <a href="{!! url('member/add-points',$member->id) !!}" class="btn btn-primary">Update Points</a>
    <a href="{!! url('rewards/items',$member->id) !!}" class="btn btn-primary">Rewards</a>
  </div>
    <div class="col m6 table-wrapper">
        <table class="table">
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
      </div>
      <div class="col m6">
        <h5>Member's Pass</h5>
        <div class="qr-wrapper">
          {!! QrCode::size(500)->generate(url('member/download-pass',$member->id)); !!}
        </div>
        <a href="{!!url('member/email-pass',$member->id)!!}" class="btn btn-primary">Email Pass</a>
      </div>
      <div class="col m12">
        <div class="row">
          <div class="col m6">
              Created: {!! date("F j, Y, g:i a", strtotime($member->created_at)) !!} <br />
              Created by: {!! $member->created_by !!}
          </div>
          <div class="col m6">
              Updated: {!! date("F j, Y, g:i a", strtotime($member->updated_at)) !!} <br />
              Last updated by: {!! $member->updated_by !!}
          </div>
        </div>
      </div>
    @endif
</div>


@stop
