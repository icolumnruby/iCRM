@extends('layouts/admin')

@section('content')
<div class="row center-align">
  <p class="headline">Welcome to iColumn Loyalty</p>
  <h4>Setup your loyalty program by following these five simple steps.</h4>
  <ul class="steps-list brand-primary-text">
    <li><p class="caption">Step One</p><i class="medium material-icons">card_membership</i><h6 class="regular brand-invert-text">Create Membership Pass</h6></li>
    <li><p class="caption">Step Two</p><i class="medium material-icons">photo_library</i><h6 class="regular brand-invert-text">Brand Your Membership</h6></li>
    <li><p class="caption">Step Three</p><i class="medium material-icons">store</i><h6 class="regular brand-invert-text">Add Branches</h6></li>
    <li><p class="caption">Step Four</p><i class="medium material-icons">person_add</i><h6 class="regular brand-invert-text">Add Branch Managers</h6></li>
    <li><p class="caption">Step Five</p><i class="medium material-icons">shopping_basket</i><h6 class="regular brand-invert-text">Add Product Categories</h6></li>
  </ul>
  <a href="{{url('setup/pass-template')}}" class="btn brand-gradient">Get Started</a>
  <p class="caption">Next Step: Create Membership Pass</p>
</div>
@if (count($company))
@endif

@stop
