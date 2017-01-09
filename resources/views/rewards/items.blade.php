@extends('layouts/admin')

@section('content')
<h3 class="page-header">Rewards List</h3>

@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {!! Session::get('flash_message') !!}
    </div>
@elseif(Session::has('error_message'))
    <div class="alert alert-danger">
        {!! Session::get('error_message') !!}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (count($rewards))

<strong>Member:</strong> {!! ucfirst($member->lastname) . ', ' . ucfirst($member->firstname) !!}<br />
<strong>Points:</strong> {!! $totalPoints !!}
<div class="rewardsList" style="padding-top: 30px;">
    @foreach ($rewards as $val)
    <div class="pull-left">
        <h4>{!! $val->name !!}</h4>
        <p>Cost: {!! $val->points !!} points</p>
        <form class="form-group" id="frmReward" method="POST" action="/rewards/redeem">
            {!! csrf_field() !!}
            <input type="hidden" name="rewardsId" value="{!! $val->id !!}" />
            <input type="hidden" name="memberId" value="{!! $member->id !!}" />
            <select class="form-control selQty" name="qty" style="width: 40%" data-dailyLimit="{!! $val->daily_limit !!}"
                 data-memberLimit="{!! $val->member_limit !!}" data-quantity="{!! $val->quantity !!}" data-points="{!! $val->points !!}">
                <option value="">Choose Quantity</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
            </select>
            <br />
            <div>
                <button type="submit" class="btn btn-primary btnSubmit" name="redeemReward">Redeem</button>
            </div>
        </form>
    </div>
    @endforeach
</div>
{!! $rewards->links() !!}
@else
    No Rewards found!
@endif


<script type="text/javascript">
    //validate if redemption is valid
//TODO Replce this with AJAX request
    var memberPts = {!! $totalPoints !!};
    $('.btnSubmit2').click(function(e) {
        e.preventDefault();
        var theForm = $(this).parents('form');
        var pts = theForm.children('.selQty').data('points');
        var dailyLimit = theForm.children('.selQty').data('dailyLimit');
        var memberLimit = theForm.children('.selQty').data('memberLimit');
        var itemQty = theForm.children('.selQty').data('quantity');
        var qty = theForm.children('.selQty').val();
        var totalPtsCost = qty * pts;

        if (qty > itemQty) {
            $('.alert-danger ul').append('<li>Quantity exceeds the maximum allowed for the item.</li>');
            return false;
        }

        if (qty > dailyLimit) {
alert('Quantity exceeds the maximum daily limit.');
            return false;
        }

        if (qty > memberLimit) {
alert('Quantity exceeds the member limit.');
            return false;
        }

        if (totalPtsCost > memberPts) {
            $('.alert-danger ul').append('<li>Not enough points.</li>');
            return false;
        }

        theForm.submit();
    });

</script>
@stop