@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

        <h2 class="page-header">Add Contact</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {!! Session::get('flash_message') !!}
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

        <form method="POST" action="/contact" name="frmContact" class="form-horizontal" id="frmContact"
              data-fv-framework="bootstrap" data-fv-message="This value is not valid">
            {!! csrf_field() !!}
            <div class="form-group form-inline">
                <label for="salutation" class="col-xs-2 control-label">Salutation</label>
                <div class="col-xs-5">
                @foreach (App\Models\Contact::$_salutation as $key => $val)
                    <label class="radio-inline">
                        <input type="radio" name="salutation" id="salutation1" value="{!!$key!!}"
                            {!! (old('salutation') == $key)? 'checked="checked"' : '' !!}
                            data-fv-notempty-message="Salutation is required" required> {!!$val!!}
                    </label>
                @endforeach
                </div>
            </div>
            <div class="form-group required">
                <label for="firstname" class="control-label col-xs-2">First Name</label>
                <div class="col-xs-5">
                    <input type="text" name="firstname" id="firstname" required placeholder="i.e. John"
                           class="form-control input-sm" value="{!! old('firstname') !!}"
                           data-fv-notempty-message="Firstname is required" required/>
                </div>
            </div>
            <div class="form-group">
                <label for="middlename" class="col-xs-2 control-label">Middle Name</label>
                <div class="col-xs-5">
                    <input type="text" name="middlename" id="middlename" placeholder="i.e. Smith"
                           class="form-control input-sm" value="{!! old('middlename') !!}" />
                </div>
            </div>
            <div class="form-group required">
                <label for="lastname" class="col-xs-2 control-label">Last Name</label>
                <div class="col-xs-5">
                    <input type="text" name="lastname" id="lastname" placeholder="i.e. Doe"
                           class="form-control input-sm" value="{!! old('lastname') !!}"
                           data-fv-notempty-message="Lastname is required" required/>
                </div>
            </div>
            <div class="form-group required">
                <label for="gender" class="col-xs-2 control-label">Gender</label>
                <div class="col-xs-5">
                @foreach (App\Models\Contact::$_gender as $key => $val)
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" id="gender1" value="{!!$key!!}"
                                   {!! (old('gender') == $key)? 'checked="checked"' : '' !!}
                                   data-fv-notempty-message="Gender is required" required> {!!$val!!}
                        </label>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="form-group required">
                <label for="email" class="col-xs-2 control-label">Email</label>
                <div class="col-xs-5">
                    <input type="text" name="email" id="email" placeholder="i.e. johndoe@test.com"
                           class="form-control input-sm" value="{!! old('email') !!}"
                           pattern="^.+\@.+\..+$"
                           data-fv-regexp-message="Please enter a valid email address" required/>
                </div>
            </div>
            <div class="form-group required">
                <label for="nric" class="col-xs-2 control-label">NRIC/Passport</label>
                <div class="col-xs-5">
                    <input type="text" name="nric" id="nric" placeholder="i.e. S1234567F"
                           class="form-control input-sm" value="{!! old('nric') !!}"
                           data-fv-notempty-message="NRIC is required" required />
                </div>
            </div>
            <div class="form-group form-inline required">
                <label for="birthdate" class="col-xs-2 control-label">Date of Birth</label>
                <div class="col-xs-5">
                    {{--*/ $dob = array(0=>'', 1=>'', 2=>'') /*--}}
                    @if (old('birthdate'))
                        {{--*/ $dob = explode('-', old('birthdate'))  /*--}}
                    @endif
                    <select class="form-control input-sm col-xs-4" id="dobYear" name="dobYear" style="margin-right: 5px">
                        <option value="0000">Year</option>
                    @for ($i = 1916; $i <= date('Y'); $i++)
                        <option value="{!! $i !!}" {{ $dob[0]== $i ? 'selected="selected"' : '' }}>{!!$i!!}</option>
                    @endfor
                    </select>
                    <select class="form-control input-sm col-xs-4" id="dobMonth" name="dobMonth" style="margin-right: 5px">
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
                    <select class="form-control input-sm col-xs-4" id="dobDay" name="dobDay" required="required">
                        <option value="00">Day</option>
                    @for ($i = 1; $i <=31; $i++)
                        <option value='{!! str_pad($i, 2, '0') !!}' {!! ($dob[2] == $i) ? 'selected="selected"' : '' !!}>{!! $i !!}</option>
                    @endfor
                    </select>
                    <div class="clearfix"></div>
                    <input type="hidden" name="birthdate" id="birthdate" data-fv-notempty-message="Birthdate is required" value="{!! old('birthdate') !!}" />
                </div>
            </div>
            <div class="form-group required">
                <label for="mobile" class="col-xs-2 control-label">Mobile</label>
                <div class="row">
                    <div class="col-xs-1">
                        @include('countryCodes', ['selected' => old('mobileCountryCode') ])
                        <input type="hidden" name="mobileCountryCode" id="mobileCountryCode" value="{!! old('mobileCountryCode') !!}" />
                    </div>
                    <div class="col-xs-2" style="padding-left: 0px">
                        <input type="text" name="mobile" id="mobile" placeholder="90051119"
                                class="form-control input-sm" value="{!! old('mobile') !!}"
                                data-fv-notempty-message="Mobile is required" required/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="country" class="col-xs-2 control-label">Country</label>
                <div class="col-xs-4">
                    <select class="form-control input-sm col-xs-4" id="countryId" name="countryId">
                        <option value="">Please Choose</option>
            @if (count($countries))
                @foreach ($countries as $val)
                        <option value="{!!$val->id!!}" {!! ($val->country == 'Singapore') ? 'selected="selected"' : '' !!}>{!!$val->country!!}</option>
                @endforeach
            @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-xs-2 control-label">State/Province</label>
                <div class="col-xs-5">
                    <input type="text" name="state" id="state" placeholder="i.e. California" class="form-control input-sm" value="{!!old('state')!!}" />
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-xs-2 control-label">City</label>
                <div class="col-xs-5">
                    <input type="text" name="city" id="city" placeholder="i.e. Los Angeles" class="form-control input-sm" value="{!!old('city')!!}" />
                </div>
            </div>
            <div class="form-group">
                <label for="postalCode" class="col-xs-2 control-label">Postal Code</label>
                <div class="col-xs-5">
                    <input type="text" name="postalCode" id="postalCode" placeholder="i.e. 445701" class="form-control input-sm" value="{!!old('postalCode')!!}" />
                </div>
            </div>
            <div class="form-group">
                <label for="nationality" class="col-xs-2 control-label">Nationality</label>
                <div class="col-xs-4">
                    <select class="form-control input-sm col-xs-4" id="nationalityId" name="nationalityId">
                        <option value="">Please Choose</option>
            @if (count($nationalities))
                @foreach ($nationalities as $val)
                        <option value="{!!$val->id!!}">{!!$val->nationality!!}</option>
                @endforeach
            @endif
                    </select>
                </div>
            </div>
            <!--div class="form-group form-inline">
                <label for="isMember" class="col-xs-2 control-label">Is Member</label>
                <div class="checkbox col-xs-2">
                    <label>
                        <input type="checkbox" name="isMember" id="isMember" value="Y" data-size="small" checked="checked" data-on-text="YES" data-off-text="NO">
                    </label>
                </div>
            </div-->
            <div class="form-group">
                <label for="memberType" class="col-xs-2 control-label">Member Type</label>
                <div class="col-xs-4">
                    <select class="form-control input-sm col-xs-4" id="memberType" name="memberType">
                        <option value="">Please Choose</option>
                @foreach (App\Models\Contact::$_memberType as $key => $val)
                        <option value="{!!$key!!}">{!!$val!!}</option>
                @endforeach
                    </select>
                </div>
            </div>
            <hr />
<!-- Start Company Meta -->
            @if (count($companyMeta))
                {{--*/ $oldMeta = count(old('meta')) ? old('meta') : [] /*--}}
                @foreach ($companyMeta as $val)
                {{--*/ $required = $val->is_mandatory == 'Y' ? 'required' : '' /*--}}
                {{--*/ $maxlength = $val->max_length > 0 ? 'data-fv-stringlength=true data-fv-stringlength-max='.$val->max_length : '' /*--}}

            <div class="form-group {!! $required !!}">
                <label for="{!! 'lbl' . $val->id !!}" class="col-xs-2 control-label">{!! $val->name !!}</label>
                <div class="col-xs-5">
                    @if ($val->type == 1) <!-- textbox -->

                    <input type="text" name="meta[{!! $val->id !!}]" id="{!! 'meta-' . $val->id !!}"
                           placeholder="{!!$val->summary!!}" class="form-control input-sm"
                           value="{!! isset($oldMeta[$val->id]) ? $oldMeta[$val->id] : '' !!}" {!! $maxlength !!} {!! $required !!} />

                    @elseif ($val->type == 2) <!-- textarea -->

                    <textarea name="meta[{!! $val->id !!}]" id="{!! 'meta-' . $val->id !!}" class="form-control"
                              rows="3" {!! $maxlength !!} {!! $required !!}>{!! isset($oldMeta[$val->id]) ? $oldMeta[$val->id] : '' !!}</textarea>

                    @elseif ($val->type == 3) <!-- dropdown -->

                        @if (count($val->options))
                            {{--*/ $options = explode('|', $val->options) /*--}}
                            {{--*/ $multiple = $val->multiselect ? 'multiple size=5' : '' /*--}}
                    <select class="form-control input-sm col-xs-4" name="meta[{!! $val->id !!}][]" id="{!! 'meta-' . $val->id !!}" {!! $multiple !!}  {!! $required !!}>
                        <option value="">Please Choose</option>
                        @foreach ($options as $value)
                        <option {!! in_array($value, (isset($oldMeta[$val->id]) ? $oldMeta[$val->id] : [])) ? 'selected="selected"' : '' !!}>{!! $value !!}</option>
                        @endforeach
                    </select>
                        @endif

                    @elseif ($val->type == 4) <!-- radio button -->

                        @if (count($val->options))
                            {{--*/ $options = explode('|', $val->options) /*--}}
                            @foreach ($options as $value)
                    <label class="radio-inline">
                        <input type="radio" name="meta[{!! $val->id !!}]" id="{!! 'meta-' . $val->id !!}"
                               value="{!!$value!!}" {!! isset($oldMeta[$val->id]) ? $oldMeta[$val->id] == $value ? 'checked="checked"' : '' : '' !!} {!! $required !!}> {!!$value!!}
                    </label>
                            @endforeach
                        @endif

                    @elseif ($val->type == 5) <!-- chechkbox -->

                        @if (count($val->options))
                            {{--*/ $options = explode('|', $val->options) /*--}}
                            @foreach ($options as $value)
                    <label class="radio-inline">
                        <input type="checkbox" name="meta[{!! $val->id !!}][]" id="{!! 'meta-' . $val->id !!}"
                               value="{!!$value!!}"  {!! in_array($value, (isset($oldMeta[$val->id]) ? $oldMeta[$val->id] : [])) ? 'checked="checked"' : '' !!}  {!! $required !!}> {!!$value!!}
                    </label>
                            @endforeach
                        @endif

                    @elseif ($val->type == 6) <!-- date -->

                    <input type="text" name="meta[{!! $val->id !!}]" id="{!! 'meta-' . $val->id !!}"
                           placeholder="{!!$val->summary!!}" class="form-control input-sm" value="{!! $oldMeta[$val->id] or '' !!}"
                           data-format="{!! $val->date_format !!}"  {!! $required !!}/>

                    @elseif ($val->type == 7) <!-- email -->

                    <input type="email" name="meta[{!! $val->id !!}]" id="{!! 'meta-' . $val->id !!}"
                           placeholder="{!!$val->summary!!}" class="form-control input-sm" value="{!! $oldMeta[$val->id] or '' !!}"
                           pattern="^.+\@.+\..+$" {!! $required !!} />

                    @elseif ($val->type == 8) <!-- number -->

                    <input type="number" name="meta[{!! $val->id !!}]" id="{!! 'meta-' . $val->id !!}"
                           placeholder="{!!$val->summary!!}" class="form-control input-sm"
                           value="{!! $oldMeta[$val->id] or '' !!}" {!! $maxlength !!} {!! $required !!} />
                    @endif
                </div>
            </div>
                @endforeach
            @endif
<!-- End Company Meta -->
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary" name="addContact">Add Contact</button>
                    <a class="btn btn-link" href="{!!route('contact.index')!!}">Cancel</a>
                </div>
            </div>

        </form>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<script type="text/javascript">
$(function() {

    $("[name='isMember']").bootstrapSwitch();

    $('#frmContact').formValidation({
            fields: {
                birthdate: {
                    excluded: false,
                }
            }
        })
        .on('err.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        })
        .on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        });

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