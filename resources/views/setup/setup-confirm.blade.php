@extends('layouts/admin')

@section('content')
<div class="row">
  <div class="col s12">
    <p class="headline">Confirm Setup</p>
    <h4>Here are your membership programme details</h4>
  </div>
  <div class="col s12">
    <h5 class="center-align">Pass Template</h5>
    <div class="pass-template" style="background-color: {!! $passTemplate->background_colour !!}; color: {!! $passTemplate->foreground_colour !!}">
      <div class="pass-header-section">
        <div class="image-drop image-dropped valign-wrapper" id="logo-input">
          <div class="dz-preview">
            <div class="dz-image">
              <img src="{!! $passTemplate->logo_url !!}">
            </div>
          </div>
        </div>
        <div class="pass-inner">
          <p class="pass-label">Member Type</p>
          <p class="pass-value">Platinum</p>
        </div>
      </div>
      <div class="pass-strip-section">
        <div class="image-drop image-dropped valign-wrapper" id="strip-input">
          <div class="dz-preview">
            <div class="dz-image">
              <img src="{!! $passTemplate->strip_url !!}">
            </div>
          </div>
        </div>
        <div class="pass-inner">
          <h1 class="skinny pass-value white-text">888</h1>
          <p class="pass-label">Points</p>
        </div>
      </div>
      <div class="pass-secondary-section">
        <div class="pass-inner">
          <p class="pass-label">Member Name</p>
          <h4 class="skinny pass-value">Alex Applesmith</h4>
        </div>
      </div>
      <div class="pass-barcode-section">
        <div class="barcode-box center-align">
          <span>Barcode</span>
        </div>
      </div>
    </div>
    <div class="divider"></div>
  </div>
  <div class="col s12 table-wrapper">
    <h5>Branches</h5>
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
      <div class="divider"></div>
  </div>
  <div class="col s12 table-wrapper">
    <h5>Managers</h5>
    @if (count($managers))
    <table class="table responsive-table highlight" id="managerList">
        <tr>
          <th>Name</th>
          <th>Email</th>
        </tr>
        @foreach ($managers as $manager)
        <tr>
          <td>{{ $manager->name }}</td>
          <td>{{ $manager->email }}</td>
        </tr>
        @endforeach
      </table>
      @endif
      <div class="divider"></div>
  </div>
  <div class="col s12 table-wrapper">
    <h5>Product Categories</h5>
    @if (count($categories))
    <table class="table responsive-table highlight" id="categoryList">
        <tr>
          <th>Category</th>
          <th>Description</th>
        </tr>
        @foreach ($categories as $category)
        <tr>
          <td>{{ $category->name }}</td>
          <td>{{ $category->description }}</td>
        </tr>
        @endforeach
      </table>
      @endif
  </div>
</div>
<div class="row">
  <div class="col s12">
    <div class="divider"></div>
    <form method="POST" action="/company/complete-setup" class="input-form">
      {!! csrf_field() !!}
      <input type="hidden" name="has_setup" value="Y" />
      <div class="section center-align">
        <a href="{{ URL::previous() }}" class="btn brand-ghost">Back</a>
        <button type="submit" class="btn brand-gradient">Confirm</button>
      </div>
      <p class="caption center-align">End of Setup</p>
    </form>
  </div>
</div>
@stop
