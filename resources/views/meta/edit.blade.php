@extends('layouts/admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        <h2 class="page-header">Edit Custom Field</h2>

@if (count($meta))

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

    {!! Form::model($meta,['method' => 'PATCH','route'=>['meta.update',$meta->id], 'class'=>'form-horizontal', 'id'=>'frmMetaUpdate']) !!}
        {{ csrf_field() }}
        <div class="form-group required">
            <label for="givenName" class="control-label col-xs-2">Name</label>
            <div class="col-xs-4">
                <input type="text" name="name" id="name" required="required" class="form-control input-sm" value="{{ $meta->name }}" />
            </div>
        </div>
        <div class="form-group required">
            <label for="fieldType" class="col-xs-2 control-label">Type</label>
            <div class="col-xs-4">
                <select class="form-control input-sm col-xs-4" id="type" name="type" required="required">
                    <option value="">Please Choose</option>
                    @foreach (App\Models\Meta::$_type as $key => $val)
                    <option value="{{ $key }}" {{ $meta->type == $key ? 'selected="selected' : '' }}>{{ ucfirst($val) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="rank" class="col-xs-2 control-label">Rank</label>
            <div class="col-xs-4">
                <select class="form-control input-sm col-xs-4" id="rank" name="rank">
                    <option value="">Please Choose</option>
                    @for ($i=1; $i <= 20; $i++)
                    <option {{ $meta->rank == $i ? 'selected="selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        {{--*/ $hide3 = 'hide' /*--}}
        @if ($meta->type == 3)
            {{--*/ $hide3 = '' /*--}}
        @endif
        <div class="form-group form-inline multiselect {{ $hide3 }}">
            <label for="multiselect" class="col-xs-2 control-label">Multi-select</label>
            <div class="checkbox col-xs-2">
                <label>
                  <input type="checkbox" name="multiselect" id="multiselect" value="1" {{ $meta->multiselect == 'Y' ? 'checked="checked"' : ''  }}>
                </label>
            </div>
        </div>
        {{--*/ $hide345 = 'hide' /*--}}
        @if ($meta->type == 3 || $meta->type == 4 || $meta->type == 5)
            {{--*/ $hide345 = '' /*--}}
        @endif
        <div class="form-group multiselect {{ $hide345 }}">
            <label for="options" class="col-xs-2 control-label">options</label>
            <div class="col-xs-3">
                <textarea name="options" id="options" class="form-control" rows="6" placeholder="One option per line">{{ preg_replace("/\|/",PHP_EOL,$meta->options) }}</textarea>
            </div>
        </div>
        {{--*/ $hide128 = 'hide' /*--}}
        @if ($meta->type == 1 || $meta->type == 2 || $meta->type == 8)
            {{--*/ $hide128 = '' /*--}}
        @endif
        <div class="form-group non-multiselect {{ $hide128 }}">
            <label for="maxLength" class="control-label col-xs-2">Character Max Length</label>
            <div class="col-xs-1">
                <input type="text" name="maxLength" id="maxLength" class="form-control input-sm"  value="{{ $meta->max_length }}" />
            </div>
        </div>
        {{--*/ $hide6 = 'hide' /*--}}
        @if ($meta->type == 6)
            {{--*/ $hide6 = 'hide' /*--}}
        @endif
        <div class="form-group {{ $hide6 }}">
            <label for="date-format" class="control-label col-xs-2">Date format</label>
            <div class="col-xs-3">
                <select class="form-control input-sm col-xs-4" id="date-format" name="date-format">
                    <option>YYYY/MM/DD</option>
                    <option>MM/DD/YYYY</option>
                    <option>DD/MM/YYYY</option>

                </select>
            </div>
        </div>
        <div class="form-group form-inline">
            <label for="mandatory" class="col-xs-2 control-label">Mandatory</label>
            <div class="checkbox col-xs-2">
                <label>
                  <input type="checkbox" name="mandatory" id="mandatory" value="Y" {{ $meta->is_mandatory == 'Y' ? 'checked="checked"' : ''  }}>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="mandatoryMsg" class="control-label col-xs-2">Mandatory Message</label>
            <div class="col-xs-4">
                <input type="text" name="mandatoryMsg" id="mandatoryMsg" class="form-control input-sm" value="{{ $meta->mandatory_msg }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="summary" class="control-label col-xs-2">Summary</label>
            <div class="col-xs-4">
                <input type="text" name="summary" id="summary" class="form-control input-sm" value="{{ $meta->summary }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="control-label col-xs-2">Description</label>
            <div class="col-xs-4">
                <textarea name="description" id="description" class="form-control" rows="2">{{ $meta->description }}</textarea>
            </div>
        </div>
        <div class="form-group form-inline">
            <label for="activated" class="col-xs-2 control-label">Activated</label>
            <div class="checkbox col-xs-2">
                <label>
                    <input type="checkbox" name="activated" id="activated" value="Y"
                           data-size="small" data-on-text="YES" data-off-text="NO"  {{ $meta->is_activated == 'Y' ? 'checked="checked"' : ''  }}>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary" name="addContact">Update</button>
                <a class="btn btn-link" href="{{route('meta.index')}}">Cancel</a>
            </div>
        </div>
    </form>
    <br />
        <p>
            Date created: {{ date("F j, Y, g:i a", strtotime($meta->created_at)) }}<br />
            Created by: {{ $meta->created_by }}
            <br /><br />
            Date updated: {{ date("F j, Y, g:i a", strtotime($meta->updated_at)) }}<br />
            Last Updated by: {{ $meta->updated_by }}
        </p>
@endif
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>

<script type="text/javascript">
$(function() {

    $("[name='mandatory'], [name='activated'], [name='multiselect']").bootstrapSwitch();
    $('#type').change(function(e) {
        $('.multiselect, .non-multiselect').addClass('hide');
        $('#options, #date-format, #maxLength').parents('.form-group').addClass('hide');

        if ($(this).val() == 3) { //dropdown
            $('.multiselect').removeClass('hide').fadeIn('slow');
        } else if ($(this).val() == 7) { //email
            $('#maxLength').parents('.form-group').fadeOut('slow', function() {
                $(this).addClass('hide');
            });
        } else if ($(this).val() == 4 || $(this).val() == 5) { //radio || checkbox
            $('#options').parents('.form-group').removeClass('hide').fadeIn('slow');
        } else if ($(this).val() == 6) { //date
            $('#date-format').parents('.form-group').removeClass('hide').fadeIn('slow');
        } else {
            $('#maxLength').parents('.form-group').removeClass('hide').fadeIn('slow');
        }
    });

    $('#frmMeta').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        err: {
            container: 'popover'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: 'Type is required'
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

});
</script>
@stop