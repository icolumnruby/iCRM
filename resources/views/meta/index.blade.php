@extends('layouts/admin')

@section('content')

<h2 class="page-header">Custom Field List</h2>

    @if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
    @endif

    @if (count($companyMeta))
    <a href="{{route('meta.create')}}" class="btn btn-success btn-sm pull-right">Create New</a>
    <form class="form-inline pull-right" style="padding: 0 7px 10px 0;" action="meta/search" method="GET">
        <input class="form-control input-sm" type="text" placeholder="Search" name="search">
        <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    </form>
    <div class="clearfix"></div>

    <table class="table table-striped table-condensed table-hover" id="tblCFList">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Is Activated</th>
            <th>Rank</th>
            <th>Created By</th>
            <th width="7%" colspan="2">Actions</th>
        </tr>
    @foreach ($companyMeta as $cm)
        <tr>
            <td>{{ $cm->id }}</td>
            <td>{{ $cm->name }}</td>
            <td>{{ ucfirst(App\Models\Meta::$_type[$cm->type]) }}</td>
            <td>{{ ($cm->is_activated == 'Y') ? 'Yes' : 'No' }}</td>
            <td>{{ $cm->rank }}</td>
            <td>{{ $cm->account_name }}</td>
            <td><a href="{{route('meta.edit',$cm->id)}}" class="btn btn-warning btn-xs">Edit</a></td>
            <td>
                <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
                   data-form="#frmDelete{!! $cm->id !!}" data-title="Delete Custom Field"
                   data-message="Are you sure you want to delete this item with ID {{ $cm->id }}?">
                    Delete
                </a>
                {!! Form::open(['method' => 'DELETE', 'route'=>['meta.destroy', $cm->id],
                    'id' => 'frmDelete'. $cm->id]) !!}
                {!! Form::close() !!}
            </td>
        </tr>
     @endforeach
     </table>
    <br />
    {!! $companyMeta->links() !!}
    @else
    <strong>No data found!</strong> <br />
    <a href="{{route('meta.create')}}" class="btn btn-success btn-sm">Create New</a>
    @endif
<!-- Include the dialog view from "views" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
jQuery(function() {
    jQuery('#tblCFList').on('click', '.btn-delete', function(e) {
        e.preventDefault();
    });
});
</script>
@stop