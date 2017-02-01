@extends('layouts/admin')

@section('content')
<div class="row ">
  <p class="headline">Setup Branch Managers</p>
  <h4>Add a branch manager to your branch</h4>
  <form method="POST" action="/branch/create-user" name="formPassTemplate" id="formPassTemplate" class="input-form">
    {!! csrf_field() !!}
    <input type="hidden" name="company_id" value="{!! $user->company_id !!}" />
    <input type="hidden" name="type" value="{!! $type !!}" />
    <input type="hidden" name="setup" value="yes" />
    <div class="input-field">
        <input type="text" name="name" id="name" required=""/>
        <label for="name">Name</label>
    </div>
    <div class="input-field">
      <select id="branch_id" name="branch_id">
        <option value="" disabled selected>Select Branch</option>
        @if (count($branches))
            @foreach ($branches as $val)
                    <option value="{!!$val->id!!}" {!! ($val->id == old('branch_id')) ? 'selected="selected"' : '' !!}>{!!$val->name!!}</option>
            @endforeach
        @endif
      </select>
      <label>Select Branch</label>
    </div>
    <div class="input-field">
        <input type="email" name="email" id="email" required="" value="{!! old('email') !!}"/>
        <label for="email">Email</label>
    </div>
    <div class="input-field">
        <input type="password" name="password" id="password" required=""/>
        <label for="password">Password</label>
    </div>
    <div class="input-field">
        <input type="password" name="password_confirmation" id="password_confirmation" required=""/>
        <label for="password_confirmation">Confirm Password</label>
    </div>
    <div class="row">
      <div class="col s12">
        <div class="switch">
          <label>
            Inactive
            <input type="checkbox" name="isActivated" id="isActivated" value="Y" checked="checked">
            <span class="lever"></span>
            Active
          </label>
        </div>
      </div>
    </div>
    <div class="center-align">
      <a href="{{ URL::previous() }}" class="btn brand-ghost">Back</a>
      <button type="submit" class="btn brand-gradient">Next</button>
    </div>
  </form>
  <p class="caption center-align">Next Step: Brand Your Membership</p>
</div>
@stop
