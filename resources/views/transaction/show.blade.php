@extends('layouts/admin')

@section('content')
    <h3 class="page-header">Transaction Detail:</h3>
    @if (count($txn))
    <div class="col-md-5">
        <table class="table table-striped">
            <tr>
                <th width="30%">ID</th>
                <td>{!! $txn->id !!}</td>
            </tr>
            <tr>
                <th>Transaction No</th>
                <td>{!! $txn->transaction_no !!}</td>
            </tr>
            <tr>
                <th>Contact</th>
                <td>{!! $txn->lastname . ', ' . $txn->firstname !!}</td>
            </tr>
            <tr>
                <th>Product</th>
                <td>{!! $txn->name !!}</td>
            </tr>
            <tr>
                <th>Payment Type</th>
                <td>{!! $txn->paymentType !!}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>{!! $txn->amount !!}</td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td>{!! $txn->remarks !!}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{!! $txn->status > 0 ? App\Models\Transaction::$_status[$txn->status] : '' !!}</td>
            </tr>
        </table>
        <p class="">
            <a href="{!!route('transaction.edit',$txn->id)!!}" class="btn btn-primary btn-m">Edit</a>
        </p>
        <div style="padding: 20px 0;">
            <div class="pull-left">
                Created: {{ date("F j, Y, g:i a", strtotime($txn->created_at)) }} <br />
                Created by: {{ $txn->created_by }}
            </div>
            <div class="pull-right">
                Updated: {{ date("F j, Y, g:i a", strtotime($txn->updated_at)) }} <br />
                Last updated by: {{ $txn->updated_by }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    @endif
@stop