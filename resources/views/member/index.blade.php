@extends('layouts/admin')

@section('content')

<h2 class="page-header">Contact List</h2>

    @if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
    @endif

    <div style="padding-bottom: 10px;">
    {!! Form::open(['method'=>'GET','url'=>'contact/search','class'=>'form-inline pull-right','role'=>'search'])  !!}
        <input class="form-control input-sm" type="text" placeholder="Search" name="search">
        <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
        <a href="{{route('contact.create')}}" class="btn btn-success btn-sm">Create New</a>
        <div class="clearfix"></div>
    {!! Form::close() !!}
    </div>

    @if (count($contacts))
    <table class="table table-striped table-condensed table-hover" id="tblContactList">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>NRIC</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gender</th>
            <th width="7%" colspan="4">Actions</th>
        </tr>
    @foreach ($contacts as $contact)
        <tr>
            <td>{{ $contact->id }}</td>
            <td>{{ ucfirst($contact->lastname) }}, {{ ucfirst($contact->firstname) }}</td>
            <td>{{ $contact->nric }}</td>
            <td>{{ !empty($contact->mobileCountryCode) ? '+'.$contact->mobileCountryCode : '' }} {{ $contact->mobile }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ ($contact->gender == 1 or $contact->gender == 2) ? App\Models\Contact::$_gender[$contact->gender] : '' }}</td>
            <td><a href="{{url('contact',$contact->id)}}" class="btn btn-primary btn-xs">View</a></td>
            <td><a href="{{route('contact.edit',$contact->id)}}" class="btn btn-warning btn-xs">Edit</a></td>
            <td>
                <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
                   data-form="#frmDelete{{ $contact->id }}" data-title="Delete Contact"
                   data-message="Are you sure you want to delete this contact with ID {{ $contact->id }}?">
                    Delete
                </a>
                {!! Form::open(['method' => 'DELETE', 'route'=>['contact.destroy', $contact->id],
                    'id' => 'frmDelete' . $contact->id]) !!}
                {!! Form::close() !!}
            </td>
            <td>
                <a href="{{url('transaction/create', $contact->id)}}" class="btn btn-warning btn-xs">Add Txn</a>
            </td>
        </tr>
     @endforeach
     </table>
    <br />
    <div class="pull-left">
        {!! $contacts->links() !!}
    </div>
    <div class="pull-left" style="margin: 27px">
        {!! 'displaying ' . $contacts->count() . ' out of ' . $contacts->total() . ' results' !!}
    </div>
{{--@include('pagination.default', ['paginator' => $contacts])--}}
     @else
        No data found!
     @endif
<!-- Include the dialog view from "views" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
jQuery(function() {
    jQuery('#tblContactList').on('click', '.btn-delete', function(e) {
        e.preventDefault();
    });
});
</script>
@stop