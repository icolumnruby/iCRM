@extends('layouts/admin')

@section('content')
<div class="row">
  <div class="col s12">
    <p class="headline">Setup Branches</p>
    <h4>Add your branch name and location</h4>
  </div>
  <div class="col s12 m6">
    <form method="POST" action="{!! route('branch.index') !!}" class="input-form" id="postForm">
      {!! csrf_field() !!}
      <input type="hidden" name="company_id" value="{!! $user->company_id !!}" />
      <input type="hidden" name="setup" value="yes" />
      <div class="input-field">
          <input type="text" name="name" id="name" required=""/>
          <label for="name">Name</label>
      </div>
      <div class="input-field">
          <textarea name="address" id="address" rows="2" class="materialize-textarea"></textarea>
          <label for="address">Address</label>
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
      <button type="submit" class="btn brand-gradient">Add Branch</button>
    </form>
  </div>
  <div class="col s12 m6 table-wrapper" style="display:none">
    @if (count($branches))
    <table class="table responsive-table highlight" id="branchList">
        <tr>
          <th>Branch</th>
          <th>Address</th>
        </tr>
        @foreach ($branches as $branch)
        <tr>
          <td>{{ $branch->name }}</td>
          <td>{{ $branch->address }}</td>
        </tr>
        @endforeach
      </table>
      @endif
  </div>
</div>
<div class="row">
  <div class="col s12">
    <div class="divider"></div>
    <div class="section center-align">
      <a href="{{ URL::previous() }}" class="btn brand-ghost">Back</a>
      <a href="/setup/managers" class="btn brand-gradient">Next</a>
    </div>
    <p class="caption center-align">Next Step: Add Managers</p>
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
         var $address = data.address;

         var $branch = '<tr><td>'+$name+'</td><td>'+$address+'</td></tr>';

         $('#branchList').append($branch);
         $('.table-wrapper').slideDown("slow");
         $('#postForm').trigger("reset");
       }).fail(function(data) {
          alert('Error:', data);
       });
     });
   });
</script>
@stop
