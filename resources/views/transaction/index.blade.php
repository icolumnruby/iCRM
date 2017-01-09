@extends('layouts/admin')

@section('content')
<h3 class="page-header">Transaction List</h3>

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {!! Session::get('flash_message') !!}
</div>
@endif

@if (count($txns))

<form class="form-inline pull-right" style="padding-bottom: 10px;">
    <input class="form-control input-sm" type="text" placeholder="Search">
    <button class="btn btn-success-outline btn-sm" type="submit">Search</button>
    <div class="clearfix"></div>
</form>

<table class="table table-striped table-condensed table-hover" id="tblTxnList">
    <tr>
        <th>ID</th>
        <th>Member</th>
        <th>Transaction No</th>
        <th>Product Category</th>
        <th>Amount</th>
        <th>Payment Type</th>
        <th>Date</th>
        <th width="7%" colspan="4">Actions</th>
    </tr>
    @foreach ($txns as $txn)
    <tr>
        <td>{!! $txn->id !!}</td>
        <td>{!! $txn->lastname ? $txn->lastname .', ' : '' !!}{!! $txn->firstname or ''!!}</td>
        <td>{!! $txn->transaction_no !!}</td>
        <td>{!! $txn->name !!}</td>
        <td>{!! '$'.$txn->amount !!}</td>
        <td>{!! $txn->payment_type !!}</td>
        <td>{!! date("F j, Y, g:i a", strtotime($txn->created_at)) !!}</td>
        <td><a href="{!! route('transaction.show', $txn->id)!!}" class="btn btn-primary btn-xs">View</a></td>
        <td><a href="{!! route('transaction.edit', $txn->id) !!}" class="btn btn-warning btn-xs">Edit</a></td>
        <td>
            <a href="#" class="formConfirm btn btn-danger btn-delete btn-xs"
               data-form="#frmDelete{!! $txn->id !!}" data-title="Delete Transaction"
               data-message="Are you sure you want to delete this transaction with ID {!! $txn->id !!}?">
                Delete
            </a>
            {!! Form::open(['method' => 'DELETE', 'route'=>['transaction.destroy', $txn->id],
            'id' => 'frmDelete' . $txn->id]) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>
{!! $txns->links() !!}
@else
    No Transactions found!
@endif

<!-- Include the dialog view from "views/dialogbox" folder -->
@include('dialogbox.delete_confirm')
<script type="text/javascript">
    $(function () {
        $('#tblTxnList').on('click', '#btnDelete', function (e) {
            e.preventDefault();
        });
    });
</script>
@stop