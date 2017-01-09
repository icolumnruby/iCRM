@extends('layouts/admin')

@section('content')

<h2 class="page-header">Export</h2>

<a href="{{url('member/export-member', $loggedin->company_id)}}" class="btn btn-primary">Export Members</a>
@stop