@extends('layouts/admin')

@section('content')
<div class="row ">
  <div class="col s12">
    <p class="headline">Setup Branch Managers</p>
    <h4>Add branch managers</h4>
  </div>
  <div class="col s12 m6">
    <form method="POST" action="/branch/create-user" class="input-form" id="postForm">
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
      <button type="submit" class="btn brand-gradient">Add Manager</button>
    </form>
  </div>
  <div class="col s12 m6 table-wrapper" style="display:none">
    <table class="table responsive-table highlight" id="managerList">
        <tr>
          <th>Name</th>
          <th>Email</th>
        </tr>
        @if (count($managers))
        @foreach ($managers as $manager)
        <tr>
          <td>{{ $manager->name }}</td>
          <td>{{ $manager->email }}</td>
        </tr>
        @endforeach
        @endif
      </table>
  </div>
</div>

<div class="row">
  <div class="col s12">
    <div class="divider"></div>
    <div class="section center-align">
      <a href="{{ URL::previous() }}" class="btn brand-ghost">Back</a>
      <a href="/setup/product-categories" class="btn brand-gradient">Next</a>
    </div>
    <p class="caption center-align">Next Step: Add Product Categories</p>
  </div>
</div>

<script type="text/javascript">
   $(document).ready(function(){
     //ajax for submitting form
     $('#postForm').on('submit', function(e) {
       e.preventDefault();
       $.ajax({
         type     : "POST",
         cache    : false,
         url      : $(this).attr('action'),
         data     : $(this).serialize(),
         dataType : 'json'
       }).done(function(data) {
         var $name = data.name;
         var $email = data.email;

         var $manager = '<tr><td>'+$name+'</td><td>'+$email+'</td></tr>';

         $('#managerList').append($manager);
         $('.table-wrapper').slideDown("slow");
         $('#postForm').trigger("reset");
       }).fail(function(data) {
          alert('Error:', data);
       });
     });
   });
</script>
@stop
