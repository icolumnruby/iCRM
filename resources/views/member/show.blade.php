@extends('layouts/admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <h2 class="page-header">Contact Detail</h2>

    @if (count($contact))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $contact->id !!}</td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td>{!! App\Models\Contact::$_salutation[$contact->salutation] !!} {!! ucfirst($contact->lastname) !!}, {!! ucfirst($contact->firstname) !!} {!! ucfirst($contact->middlename) !!}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{!! App\Models\Contact::$_gender[$contact->gender] !!}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{!! $contact->email !!}</td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>{!! $contact->mobile_country_code . $contact->mobile !!}</td>
            </tr>
            <tr>
                <th>NRIC</th>
                <td>{!! $contact->nric !!}</td>
            </tr>
            <tr>
                <th>Birthdate</th>
                <td>{!! $contact->birthdate !!}</td>
            </tr>
            <tr>
                <th>Nationality</th>
                <td>{!! $contact->nationality !!}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{!! $contact->address !!}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{!! $contact->city !!}</td>
            </tr>
            <tr>
                <th>State</th>
                <td>{!! $contact->state !!}</td>
            </tr>
            <tr>
                <th>Country</th>
                <td>{!! $contact->country !!}</td>
            </tr>
            <!--tr>
                <th>Is Member</th>
                <td>{!! $contact->is_member ? 'Yes' : 'No' !!}</td>
            </tr-->
            <tr>
                <th>Member Type</th>
                <td>{!! $contact->member_type ? App\Models\Contact::$_memberType[$contact->member_type] : '' !!}</td>
            </tr>
        </table>

        @if (count($contactMeta))
        <br /> <h4><strong>Custom Fields</strong></h4>
        <table class="table table-striped">
            @foreach ($contactMeta as $val)
            <tr>
                <th width="40%">{!! $val->name !!}</th>
                <td>{!! $val->cmv_value !!}</td>
            </tr>
            @endforeach
        </table>
        <br/>

        @endif

        <div class="col-md-5">
            Created: {!! date("F j, Y, g:i a", strtotime($contact->created_at)) !!} <br />
            Created by: {!! $contact->created_by !!}
        </div>
        <div class="col-md-5 pull-right">
            Updated: {!! date("F j, Y, g:i a", strtotime($contact->updated_at)) !!} <br />
            Last updated by: {!! $contact->updated_by !!}
        </div>
        <div class="clearfix"></div>
        <br />
        <p class=""><a href="{!!route('contact.edit',$contact->id)!!}" class="btn btn-primary btn-m">Edit</a>
        <a href="{!!url('transaction/create', $contact->id)!!}" class="btn btn-primary btn-m">Add Transaction</a>
        </p>
    </div>
    @endif


        </div>
    </div>
</div>


@stop