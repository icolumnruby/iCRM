@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
@if (count($contact))
            <h2 class="page-header">Update Contact</h2>
@if(Session::has('flash_message'))
<div class="alert alert-success">
    {{ Session::get('flash_message') }}
</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{!! Form::model($contact,['method' => 'PATCH','route'=>['contact.update',$contact->id], 'class'=>'form-horizontal', 'id'=>'frmContactUpdate']) !!}
    {{ csrf_field() }}
    <div class="form-group form-inline">
        <label for="salutation" class="col-xs-2 control-label">Salutation</label>
        <div class="col-xs-5">
            @foreach (App\Models\Contact::$_salutation as $key => $val)
            <label class="radio-inline">
                <input type="radio" name="salutation" id="salutation1" value="{{$key}}" {{ ($contact->salutation == $key)? 'checked="checked"' : '' }}> {{$val}}
            </label>
            @endforeach
        </div>
    </div>
    <div class="form-group required">
        <label for="firstname" class="control-label col-xs-2">First Name</label>
        <div class="col-xs-5">
            <input type="text" name="firstname" id="firstname" placeholder="i.e. John" class="form-control input-sm" value="{{ ucfirst($contact->firstname) }}" />
        </div>
    </div>
    <div class="form-group">
        <label for="middlename" class="col-xs-2 control-label">Middle Name</label>
        <div class="col-xs-5">
            <input type="text" name="middlename" id="middlename" placeholder="i.e. Smith" class="form-control input-sm" value="{{ ucfirst($contact->middlename) }}" />
        </div>
    </div>
    <div class="form-group required">
        <label for="lastname" class="col-xs-2 control-label">Last Name</label>
        <div class="col-xs-5">
            <input type="text" name="lastname" id="lastname" placeholder="i.e. Doe" class="form-control input-sm" value="{{ ucfirst($contact->lastname) }}" />
        </div>
    </div>
    <div class="form-group required">
        <label for="gender" class="col-xs-2 control-label">Gender</label>
        <div class="col-xs-5">
            @foreach (App\Models\Contact::$_gender as $key => $val)
            <label class="radio-inline">
                <input type="radio" name="gender" id="gender1" value="{{$key}}" {{ ($contact->gender == $key)? 'checked="checked"' : '' }}> {{$val}}
            </label>
            @endforeach
        </div>
    </div>
    <div class="form-group required">
        <label for="email" class="col-xs-2 control-label">Email</label>
        <div class="col-xs-5">
            <input type="text" name="email" id="email" placeholder="i.e. johndoe@test.com" class="form-control input-sm" value="{{ $contact->email }}" />
        </div>
    </div>
    <div class="form-group required">
        <label for="nric" class="col-xs-2 control-label">NRIC/Passport</label>
        <div class="col-xs-5">
            <input type="text" name="nric" id="nric" placeholder="i.e. S1234567F" class="form-control input-sm" value="{{ $contact->nric }}" />
        </div>
    </div>
    <div class="form-group form-inline required">
        <label for="birthdate" class="col-xs-2 control-label">Date of Birth</label>
        <div class="col-xs-9">
            {{--*/ $dob = [] /*--}}
            @if ($contact->birthdate)
                {{--*/ $dob = explode('-', $contact->birthdate)  /*--}}
            @endif
            <select class="form-control input-sm col-xs-4" id="dobYear" name="dobYear" style="margin-right: 5px">
                <option value="0000">Year</option>
            @for ($i = date('Y'); $i >= 1916; $i--)
                <option value="{{ $i }}" {{ $dob[0]== $i ? 'selected="selected"' : '' }}>{{$i}}</option>
            @endfor
            </select>
            <select class="form-control input-sm col-xs-4" id="dobMonth" name="dobMonth" style="margin-right: 5px">
                <option value="00">Month</option>
                <option value='01' {{ $dob[1]== '01' ? 'selected="selected"' : '' }}>January</option>
                <option value='02' {{ $dob[1]== '02' ? 'selected="selected"' : '' }}>February</option>
                <option value='03' {{ $dob[1]== '03' ? 'selected="selected"' : '' }}>March</option>
                <option value='04' {{ $dob[1]== '04' ? 'selected="selected"' : '' }}>April</option>
                <option value='05' {{ $dob[1]== '05' ? 'selected="selected"' : '' }}>May</option>
                <option value='06' {{ $dob[1]== '06' ? 'selected="selected"' : '' }}>June</option>
                <option value='07' {{ $dob[1]== '07' ? 'selected="selected"' : '' }}>July</option>
                <option value='08' {{ $dob[1]== '08' ? 'selected="selected"' : '' }}>August</option>
                <option value='09' {{ $dob[1]== '09' ? 'selected="selected"' : '' }}>September</option>
                <option value='10' {{ $dob[1]== '10' ? 'selected="selected"' : '' }}>October</option>
                <option value='11' {{ $dob[1]== '11' ? 'selected="selected"' : '' }}>November</option>
                <option value='12' {{ $dob[1]== '12' ? 'selected="selected"' : '' }}>December</option>
            </select>
            <select class="form-control input-sm col-xs-4" id="dobDay" name="dobDay" required="required">
                <option value="00">Day</option>
                @for ($i = 1; $i <=31; $i++)
                <option value='{{ str_pad($i, 2, '0') }}' {{ ($dob[2] == $i) ? 'selected="selected"' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <div class="clearfix"></div>
            <input type="hidden" name="birthdate" id="birthdate" value="{{ $contact->birthdate }}" />
        </div>
    </div>
    <div class="form-group required">
        <label for="mobile" class="col-xs-2 control-label">Mobile</label>
        <div class="row">
            <div class="col-xs-2">
                @include('countryCodes', ['selected' => $contact->mobileCountryCode])
                <input type="hidden" name="mobileCountryCode" id="mobileCountryCode" value="{{$contact->mobileCountryCode}}" />
            </div>
            <div class="col-xs-2" style="padding-left: 0px">
                <input type="text" name="mobile" id="mobile" placeholder="90051119" class="form-control input-sm" value="{{ $contact->mobile }}" />
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
                <option value="{{$val->id}}" {{ ($contact->countryId == $val->id ? 'selected="selected"': '') }}>{{$val->country}}</option>
                @endforeach
            @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-xs-2 control-label">State/Province</label>
        <div class="col-xs-5">
            <input type="text" name="state" id="state" placeholder="i.e. California" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label for="city" class="col-xs-2 control-label">City</label>
        <div class="col-xs-5">
            <input type="text" name="city" id="city" placeholder="i.e. Los Angeles" class="form-control input-sm" value="{{ $contact->city }}" />
        </div>
    </div>
    <div class="form-group">
        <label for="postalCode" class="col-xs-2 control-label">Postal Code</label>
        <div class="col-xs-5">
            <input type="text" name="postalCode" id="postalCode" placeholder="i.e. 445701" class="form-control input-sm" value="{{ $contact->postalCode }}" />
        </div>
    </div>
    <div class="form-group">
        <label for="nationality" class="col-xs-2 control-label">Nationality</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="nationalityId" name="nationalityId">
                <option value="">Please Choose</option>
            @if (count($nationalities))
                @foreach ($nationalities as $val)
                <option value="{{$val->id}}" {{ ($contact->nationalityId == $val->id ? 'selected="selected"': '') }}>{{$val->nationality}}</option>
                @endforeach
            @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="memberType" class="col-xs-2 control-label">Member Type</label>
        <div class="col-xs-4">
            <select class="form-control input-sm col-xs-4" id="memberType" name="memberType">
                <option value="">Please Choose</option>
        @foreach (App\Models\Contact::$_memberType as $key => $val)
                <option value="{{$key}}" {{ ($contact->member_type == $key ? 'selected="selected"': '') }}>{{$val}}</option>
        @endforeach
            </select>
        </div>
    </div>
    <hr />
    @if (count($contactMeta))
        @foreach ($contactMeta as $val)
    <div class="form-group {{ $val->is_mandatory == 'Y' ? 'required' : '' }}">
        <label for="{{ 'lbl' . $val->meta_id }}" class="col-xs-2 control-label">{{ $val->name or '' }}</label>
        <div class="col-xs-5">
            @if ($val->type == 1) <!-- textbox -->

            <input type="text" name="meta[{{ $val->meta_id }}]" id="{{ 'meta-' . $val->meta_id }}"
                   placeholder="{{$val->summary}}" class="form-control input-sm" value="{{ $val->cmv_value }}" />

            @elseif ($val->type == 2) <!-- textarea -->

            <textarea name="meta[{{ $val->meta_id }}]" id="{{ 'meta-' . $val->meta_id }}" class="form-control" rows="3">{{ $val->cmv_value }}</textarea>

            @elseif ($val->type == 3) <!-- dropdown -->

                @if (count($val->options))
                    {{--*/ $options = explode('|', $val->options) /*--}}
                    {{--*/ $multiple = $val->multiselect ? 'multiple size=5' : '' /*--}}
                    {{--*/ $optionVal = explode('|', $val->cmv_value) /*--}}
            <select class="form-control input-sm col-xs-4" name="meta[{{ $val->meta_id }}][]" id="{{ 'meta-' . $val->meta_id }}" {{ $multiple }}>
                @if (!$val->multiselect)
                <option value="">Please Choose</option>
                @endif
                @foreach ($options as $value)
                <option {{ in_array($value, $optionVal) ? 'selected="selected"' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
                @endif

            @elseif ($val->type == 4) <!-- radio button -->

                @if (count($val->options))
                    {{--*/ $options = explode('|', $val->options) /*--}}

                    @foreach ($options as $value)
            <label class="radio-inline">
                <input type="radio" name="meta[{{ $val->meta_id }}]" id="{{ 'meta-' . $val->meta_id }}" value="{{$value}}" {{ $val->cmv_value == $value ? 'checked="checked"' : '' }}> {{$value}}
            </label>
                    @endforeach
                @endif

            @elseif ($val->type == 5) <!-- chechkbox -->

                @if (count($val->options))
                    {{--*/ $options = explode('|', $val->options) /*--}}
                    {{--*/ $optionVal = explode('|', $val->cmv_value) /*--}}
                    @foreach ($options as $value)
            <label class="radio-inline">
                <input type="checkbox" name="meta[{{ $val->meta_id }}][]" id="{{ 'meta-' . $val->meta_id }}" value="{{$value}}" {{ in_array($value, $optionVal) ? 'checked="checked"' : '' }}> {{$value}}
            </label>
                    @endforeach
                @endif

            @elseif ($val->type == 6) <!-- date -->

            <input type="text" name="meta[{{ $val->meta_id }}]" id="{{ 'meta-' . $val->meta_id }}"
                   placeholder="{{$val->summary}}" class="form-control input-sm" value="{{ $val->cmv_value }}"
                   data-format="{{ $val->date_format }}"/>

            @elseif ($val->type == 7) <!-- email -->

            <input type="text" name="meta[{{ $val->id }}]" id="{{ 'meta-' . $val->id }}"
                   placeholder="{{$val->summary}}" class="form-control input-sm" value="{{ $val->cmv_value }}"
                   pattern="/^.+\@.+\..+$/i" />

            @elseif ($val->type == 8) <!-- number -->

            <input type="number" name="meta[{{ $val->meta_id }}]" id="{{ 'meta-' . $val->meta_id }}"
                   placeholder="{{$val->summary}}" class="form-control input-sm" value="{{ $val->cmv_value }}" />
            @endif
        </div>
    </div>
        @endforeach
    @endif

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-link" href="{{route('contact.index')}}">Cancel</a>
        </div>
    </div>

{!! Form::close() !!}
    <div class="col-xs-7" style="padding: 20px 0">
        <div class="pull-left">
            Created: {{ date("F j, Y, g:i a", strtotime($contact->created_at)) }} <br />
            Created by: {{ $contact->created_by }}
        </div>
        <div class="pull-right">
            Updated: {{ date("F j, Y, g:i a", strtotime($contact->updated_at)) }} <br />
            Last updated by: {{ $contact->updated_by }}
        </div>
        <div class="clearfix"></div>
    </div>
@else
    Contact doesn't exist!
@endif
</div>
</div>
</div>
<script type="text/javascript">
$(function() {

    $("[name='isMember']").bootstrapSwitch();
    $('#frmContactUpdate').formValidation({
        framework: 'bootstrap',
        icon: {
            invalid: 'glyphicon glyphicon-remove'
        },
        fields: {
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'First Name is required'
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'Last Name is required'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'Gender is required'
                    }
                }
            },
            email2: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
                    email: {
                        message: 'The input is not a valid email address'
                    },
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    }
                }
            },
            nric2: {
                validators: {
                    notEmpty: {
                        message: 'NRIC/Passport is required'
                    }
                }
            },
            birthdate: {
                // The hidden input will not be ignored
//                excluded: false,
                validators: {
                    notEmpty: {
                        message: 'The date is required'
                    }
                }
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
//TODO fix the birthdate validation
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

    $('#selectOccupation').change(function() {
        if ($(this).val() == 'Others') {
            $('#occupation').attr('type', 'text');
            $('#occupation').val('');
        } else {
            $('#occupation').attr('type', 'hidden');
            $('#occupation').val($(this).val());
        }
    });

     $('#selectRace').change(function() {
        if ($(this).val() == 'Others') {
            $('#race').attr('type', 'text');
            $('#race').val('');
        } else {
            $('#race').attr('type', 'hidden');
            $('#race').val($(this).val());
        }
    });

    $('#countryCode').change(function() {
        $('#mobileCountryCode').val($(this).val());
    });

});
</script>
@stop