@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Branch Detail:</h3>
    @if (count($branch))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $branch->id !!}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{!! $branch->name !!}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{!! $branch->address !!}</td>
            </tr>
            <tr>
                <th>Activated</th>
                <td>{!! $branch->is_activated == 'Y' ? 'Yes' : 'No' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('branch.edit',$branch->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
            <div class="pull-left">
                Created: {{ date("F j, Y, g:i a", strtotime($branch->created_at)) }} <br />
                Created by: {{ $branch->created_by }}
            </div>
            <div class="pull-right">
                Updated: {{ date("F j, Y, g:i a", strtotime($branch->updated_at)) }} <br />
                Last updated by: {{ $branch->updated_by }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    @endif
@stop