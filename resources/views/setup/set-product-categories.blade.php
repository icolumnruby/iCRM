@extends('layouts/admin')

@section('content')
<div class="row">
  <div class="col s12">
    <p class="headline">Setup Product Categories</p>
    <h4>Add product categories</h4>
  </div>
  <div class="col s12 m6">
    <form method="POST" action="/product/category" class="input-form" id="postForm">
      {!! csrf_field() !!}
      <input type="hidden" name="companyId" value="{!! $user->company_id !!}" />
      <input type="hidden" name="setup" value="yes" />
      <div class="input-field">
          <input type="text" name="name" id="name" required=""/>
          <label for="name">Category Name</label>
      </div>
      <div class="input-field">
          <textarea name="description" id="description" rows="2" class="materialize-textarea"></textarea>
          <label for="description">Description</label>
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
      <button type="submit" class="btn brand-gradient">Add Product Category</button>
    </form>
  </div>
  <div class="col s12 m6 table-wrapper" style="display:none">
    <table class="table responsive-table highlight" id="categoryList">
        <tr>
          <th>Category</th>
          <th>Description</th>
        </tr>
        @if (count($categories))
        @foreach ($categories as $category)
        <tr>
          <td>{{ $category->name }}</td>
          <td>{{ $category->description }}</td>
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
      <a href="/setup/confirm" class="btn brand-gradient">Next</a>
    </div>
    <p class="caption center-align">Next Step: Confirm Setup</p>
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
         var $description = data.description;

         var $category = '<tr><td>'+$name+'</td><td>'+$description+'</td></tr>';

         $('#categoryList').append($category);
         $('.table-wrapper').slideDown("slow");
         $('#postForm').trigger("reset");
       }).fail(function(data) {
          alert('Error:', data);
       });
     });
   });
</script>
@stop
