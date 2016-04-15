@extends('patients::layouts.inner')
@section('header-content') Create New Patient's Profile @stop

@section('patient-content')
    {!! Form::open(array('url' => 'patients/save', 'name'=>'crudForm', 'class'=>'form-horizontal', 'id'=>'wizardForm')) !!}
    <div class="nav-tabs-custom">
        @include('patients::partials.tab_nav')

        <div class="tab-content">
            @include('patients::pages.forms.add_basic_info')
            @include('patients::pages.forms.add_personal')
            @include('patients::pages.forms.location')
            @include('patients::pages.forms.allergies_alerts')
            @include('patients::pages.forms.notification_settings')
            @include('patients::pages.forms.photos')
        </div>
    </div>
  <div class="wizard-buttons">
  <input class="btn btn-success" id="back" value="Back" type="reset" />
  <input type="submit" class="btn btn-success" id="next" value="Next" />
  </div>
  {!! Form::close() !!}
@stop

@section('patient-footer')
@stop

@section('scripts')
  <script>
    var patientId = ""; //fix patient.js - shouldn't accept this when at add page
  </script>

  {!! HTML::script('public/dist/js/prettify.js') !!}
  {!! HTML::script('public/dist/plugins/chain/jquery.chained.min.js') !!}
  {!! HTML::script('public/dist/plugins/chain/jquery.chained.remote.min.js') !!}

  <script>
    function show_maiden()
    {
      var marital_status = $("#marital_status_field").val();
      var gender = $(".gender:checked").val();

      if (marital_status == 'M' && gender == 'F')
      {
        $('.maiden').show();
      }
      else
      {
        $('.maiden').hide();
      }
    }

    $(document).ready(function () {
        show_maiden();
    });
  </script>

  {!! HTML::script('public/dist/js/pages/patients/patients.js') !!}
@stop
