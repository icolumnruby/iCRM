@extends('layouts/admin')

@section('content')

<h2 class="page-header">Member List</h2>

    @if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
    @endif

    <div style="padding-bottom: 10px;">
    {!! Form::open(['method'=>'GET','url'=>'member/search','class'=>'form-inline pull-right','role'=>'search'])  !!}
        <input class="form-control input-sm" type="text" placeholder="Search" name="search">
        <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
        <a href="{{route('member.create')}}" class="btn btn-success btn-sm">Create New</a>
        <div class="clearfix"></div>
    {!! Form::close() !!}
    </div>

    @if (count($members))
    <table class="table table-striped table-condensed table-hover" id="tblMemberList">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>NRIC</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gender</th>
            <th width="7%" colspan="5">Actions</th>
        </tr>
    @foreach ($members as $member)
        <tr>
            <td>{{ $member->id }}</td>
            <td>
                <a href="{{url('member',$member->id)}}">
                    {{ ucfirst($member->lastname) }}, {{ ucfirst($member->firstname) }}
                </a>
            </td>
            <td>{{ $member->nric }}</td>
            <td>{{ !empty($member->mobileCountryCode) ? '+'.$member->mobileCountryCode : '' }} {{ $member->mobile }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ ($member->gender == 1 or $member->gender == 2) ? App\Models\Member::$_gender[$member->gender] : '' }}</td>
            <td><a href="{{route('member.edit',$member->id)}}" class="btn btn-warning btn-xs">Edit</a></td>
            <td>
                <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
                   data-form="#frmDelete{{ $member->id }}" data-title="Delete Member"
                   data-message="Are you sure you want to delete this member with ID {{ $member->id }}?">
                    Delete
                </a>
                {!! Form::open(['method' => 'DELETE', 'route'=>['member.destroy', $member->id],
                    'id' => 'frmDelete' . $member->id]) !!}
                {!! Form::close() !!}
            </td>
            <td>
                <a href="{{url('transaction/create', $member->id)}}" class="btn btn-primary btn-xs">Add Txn</a>
            </td>
            <td><a href="{{url('member/add-points',$member->id)}}" class="btn btn-primary btn-xs">Update Points</a></td>
            <td><a href="{{url('rewards/items',$member->id)}}" class="btn btn-primary btn-xs">Rewards</a></td>
        </tr>
     @endforeach
     </table>
    <br />
    <div class="pull-left">
        {!! $members->links() !!}
    </div>
    <div class="pull-left" style="margin: 27px">
        {!! 'displaying ' . $members->count() . ' out of ' . $members->total() . ' results' !!}
    </div>
{{--@include('pagination.default', ['paginator' => $members])--}}
     @else
        No data found!
     @endif
<!-- Include the dialog view from "views" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
jQuery(function() {
    jQuery('#tblMemberList').on('click', '.btn-delete', function(e) {
        e.preventDefault();
    });
});
</script>
@stop