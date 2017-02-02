@extends('layouts/admin')
@section('content-theme', 'bright')
@section('content')
<div class="section-header row">
  <div class="col m8">
    <h3>Member List</h3>
  </div>

  <div class="col m4">
    {!! Form::open(['method'=>'GET','url'=>'member/search','class'=>'form-inline','role'=>'search'])  !!}
      <div class="input-field input-group">
        <input class="form-control input-sm" type="text" name="search" placeholder="Search">
        <button class="btn-form" type="submit"><i class="material-icons">search</i></button>
      </div>
    {!! Form::close() !!}
  </div>
  <div class="col m12">
    <a href="{{route('member.create')}}" class="btn brand-gradient"><i class="material-icons left">add</i>Add New Member</a>
  </div>
</div>
<div class="row">
  <div class="col m12 table-wrapper">
    @if (count($members))
    <table class="table responsive-table highlight" id="tblMemberList">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>NRIC</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Actions</th>
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
            <td><a href="{{route('member.edit',$member->id)}}" class="btn amber btn-xs"><i class="material-icons">edit</i></a></td>
            <td>
                <a href="#" class="formConfirm btn red btn-delete btn-xs"
                   data-form="#frmDelete{{ $member->id }}" data-title="Delete Member"
                   data-message="Are you sure you want to delete this member with ID {{ $member->id }}?">
                    <i class="material-icons">delete</i>
                </a>
                {!! Form::open(['method' => 'DELETE', 'route'=>['member.destroy', $member->id],
                    'id' => 'frmDelete' . $member->id]) !!}
                {!! Form::close() !!}
            </td>
            <td>
                <a href="{{url('transaction/create', $member->id)}}" class="btn brand-gradient btn-xs">Add Txn</a>
            </td>
            <td><a href="{{url('member/add-points',$member->id)}}" class="btn brand-gradient btn-xs">Update Points</a></td>
            <td><a href="{{url('rewards/items',$member->id)}}" class="btn brand-gradient btn-xs">Rewards</a></td>
        </tr>
     @endforeach
     </table>
   </div>
  <br />
  <div class="pull-left">
      @include('pagination.custom', ['paginator' => $members])
  </div>
  <div class="pull-left" style="margin: 27px">
      {!! 'displaying ' . $members->count() . ' out of ' . $members->total() . ' results' !!}
  </div>
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
