@extends('layouts/admin')
@section('content-theme', 'bright')
@section('content')
<div class="section-header row">
    <div class="col m12">
      <h3>Add Member</h3>
    </div>
</div>
<div class="row">
    <form method="POST" action="/member" name="frmMember" id="frmMember" class="col s12" data-parsley-validate>
        {!! csrf_field() !!}
        <div class="row">
          <div class="input-field radio-field col s12 required">
              @foreach (App\Models\Member::$_salutation as $key => $val)
                <input type="radio" name="salutation" id="salutation{!!$key!!}" class="validate" value="{!!$key!!}"
                    {!! (old('salutation') == $key)? 'checked="checked"' : '' !!}
                    data-fv-notempty-message="Salutation is required" required>
                <label for="salutation{!!$key!!}">{!!$val!!}</label>
              @endforeach
              <p><label class="active">Salutation</label></p>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 l4 required">
            <input type="text" name="firstname" id="firstname" class="validate" required placeholder="i.e. John"
                   class="form-control input-sm" value="{!! old('firstname') !!}"
                   data-fv-notempty-message="Firstname is required" required data-parsley-required>
            <label for="firstname">First Name</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="middlename" id="middlename" placeholder="i.e. Smith"
                   class="form-control input-sm" value="{!! old('middlename') !!}" >
            <label for="middlename">Middle Name</label>
          </div>
          <div class="input-field col s12 l4 required">
            <input type="text" name="lastname" id="lastname" class="validate" placeholder="i.e. Doe"
                   class="form-control input-sm" value="{!! old('lastname') !!}"
                   data-fv-notempty-message="Lastname is required" required data-parsley-required>
            <label for="lastname">Last Name</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field radio-field col s12 required">
              @foreach (App\Models\Member::$_gender as $key => $val)
                <input type="radio" name="gender" id="gender{!!$key!!}" value="{!!$key!!}"
                       {!! (old('gender') == $key)? 'checked="checked"' : '' !!}
                       data-fv-notempty-message="Gender is required" required data-parsley-required>
                <label for="gender{!!$key!!}">{!!$val!!}</label>
              @endforeach
              <label class="active">Gender</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 required">
            <div class="row">
              <div class="col s12">
                <input type="text" name="email" id="email" placeholder="i.e. johndoe@test.com"
                       class="validate" value="{!! old('email') !!}"
                       pattern="^.+\@.+\..+$"
                       data-fv-regexp-message="Please enter a valid email address" required data-parsley-required/>
                <label for="email">Email</label>
              </div>
              <div class="col s12">
                <input type="checkbox" name="emailSubscribe" id="emailSubscribe" value="Y"
                           {!! (old('emailSubscribe') == 'Y')? 'checked="checked"' : '' !!}>
                <label for="emailSubscribe">Subscribe thru Email</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 required">
            <div class="row">
              <div class="col s4">
                @include('countryCodes', ['selected' => old('mobileCountryCode') ])
              </div>
              <div class="col s8">
                <input type="hidden" name="mobileCountryCode" id="mobileCountryCode" value="{!! old('mobileCountryCode') !!}" />
                <input type="text" name="mobile" id="mobile" placeholder="i.e. 91234567"
                        class="form-control input-sm" value="{!! old('mobile') !!}"
                        data-fv-notempty-message="Mobile is required" required data-parsley-required/>
                <label for="mobile">Mobile</label>
              </div>
              <div class="col s12">
                <input type="checkbox" name="smsSubscribe" id="smsSubscribe" value="Y"
                       {!! (old('smsSubscribe') == 'Y')? 'checked="checked"' : '' !!}>
                <label for="smsSubscribe">Subscribe thru SMS</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 required">
            <input type="text" name="nric" id="nric" placeholder="i.e. S1234567F"
                   class="form-control input-sm" value="{!! old('nric') !!}"
                   data-fv-notempty-message="NRIC is required" required />
            <label for="nric">NRIC/Passport</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 required">
              <div class="row">
                {{--*/ $dob = array(0=>'', 1=>'', 2=>'') /*--}}
                @if (old('birthdate'))
                    {{--*/ $dob = explode('-', old('birthdate'))  /*--}}
                @endif
                <select class="col s4" id="dobYear" name="dobYear">
                    <option value="0000">Year</option>
                @for ($i = 1916; $i <= date('Y'); $i++)
                    <option value="{!! $i !!}" {{ $dob[0]== $i ? 'selected="selected"' : '' }}>{!!$i!!}</option>
                @endfor
                </select>
                <select class="col s4" id="dobMonth" name="dobMonth">
                    <option value="00">Month</option>
                    <option value='01' {!! $dob[1]== '01' ? 'selected="selected"' : '' !!}>January</option>
                    <option value='02' {!! $dob[1]== '02' ? 'selected="selected"' : '' !!}>February</option>
                    <option value='03' {!! $dob[1]== '03' ? 'selected="selected"' : '' !!}>March</option>
                    <option value='04' {!! $dob[1]== '04' ? 'selected="selected"' : '' !!}>April</option>
                    <option value='05' {!! $dob[1]== '05' ? 'selected="selected"' : '' !!}>May</option>
                    <option value='06' {!! $dob[1]== '06' ? 'selected="selected"' : '' !!}>June</option>
                    <option value='07' {!! $dob[1]== '07' ? 'selected="selected"' : '' !!}>July</option>
                    <option value='08' {!! $dob[1]== '08' ? 'selected="selected"' : '' !!}>August</option>
                    <option value='09' {!! $dob[1]== '09' ? 'selected="selected"' : '' !!}>September</option>
                    <option value='10' {!! $dob[1]== '10' ? 'selected="selected"' : '' !!}>October</option>
                    <option value='11' {!! $dob[1]== '11' ? 'selected="selected"' : '' !!}>November</option>
                    <option value='12' {!! $dob[1]== '12' ? 'selected="selected"' : '' !!}>December</option>
                </select>
                <select class="col s4" id="dobDay" name="dobDay" required="required">
                    <option value="00">Day</option>
                @for ($i = 1; $i <=31; $i++)
                    <option value='{!! str_pad($i, 2, '0') !!}' {!! ($dob[2] == $i) ? 'selected="selected"' : '' !!}>{!! $i !!}</option>
                @endfor
                </select>
                <label for="birthdate">Date of Birth</label>
                <input type="hidden" name="birthdate" id="birthdate" data-fv-notempty-message="Birthdate is required" value="{!! old('birthdate') !!}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <select id="countryId" name="countryId">
                <option value="">Please Choose</option>
    @if (count($countries))
        @foreach ($countries as $val)
                <option value="{!!$val->id!!}" {!! ($val->name == 'Singapore') ? 'selected="selected"' : '' !!}>{!!$val->name!!}</option>
        @endforeach
    @endif
            </select>
            <label for="countryId">Country</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" name="state" id="state" placeholder="i.e. California" value="{!!old('state')!!}" />
            <label for="state">State/Province</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" name="city" id="city" placeholder="i.e. Los Angeles" value="{!!old('city')!!}" />
            <label for="city">City</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" name="postalCode" id="postalCode" placeholder="i.e. 445701" value="{!!old('postalCode')!!}" />
            <label for="postalCode">Postal Code</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <select id="nationalityId" name="nationalityId">
                <option value="">Please Choose</option>
    @if (count($nationalities))
        @foreach ($nationalities as $val)
                <option value="{!!$val->id!!}">{!!$val->nationality!!}</option>
        @endforeach
    @endif
            </select>
            <label for="nationality">Nationality</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 required">
            <select id="memberTypeId" name="memberTypeId">
                <option value="">Please Choose</option>
        @foreach (App\Models\Member::$_memberType as $key => $val)
                <option value="{!!$key!!}" {!! $key == old('memberTypeId') ? 'selected="selected"' : '' !!}>{!!$val!!}</option>
        @endforeach
            </select>
            <label for="memberType">Member Type</label>
          </div>

        </div>
        <div class="row">
          <div class="input-field col s12">
              <div class="col-xs-offset-2 col-xs-10">
                  <button type="submit" class="btn brand-gradient" name="addMember">Add Member</button>
                  <a class="btn btn-link" href="{!!route('member.index')!!}">Cancel</a>
              </div>
          </div>
        </div>
    </form>
</div>
<!-- /.row -->
<script type="text/javascript">
$(function() {


    // $('#frmMember').formValidation({
    //         fields: {
    //             birthdate: {
    //                 excluded: false,
    //             },
    //             memberTypeId: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'Member type is required'
    //                     }
    //                 }
    //             }
    //         }
    //     })
    //     .on('err.field.fv', function(e, data) {
    //         if (data.fv.getSubmitButton()) {
    //             data.fv.disableSubmitButtons(false);
    //         }
    //     })
    //     .on('success.field.fv', function(e, data) {
    //         if (data.fv.getSubmitButton()) {
    //             data.fv.disableSubmitButtons(false);
    //         }
    //     });

    //birthdate should have at least a month
    $('#dobYear, #dobMonth, #dobDay').change(function(e) {
        e.preventDefault();
        var dob = [$('#dobYear').val(), $('#dobMonth').val(), $('#dobDay').val()];
        var dobVal = dob.join('-');
        if ($('#dobMonth').val() == '00') {
            $('#birthdate').val('');
        } else {
            $('#birthdate').val(dobVal);
        }
    });

    $('#countryCode').change(function() {
        $('#mobileCountryCode').val($(this).val());
    });

});
</script>
@stop
