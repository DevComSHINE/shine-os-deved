@section('heads')
{!! HTML::style('public/dist/css/prettify.css') !!}
{!! HTML::style('public/dist/plugins/datepicker/datepicker3.css') !!}
{!! HTML::style('public/dist/plugins/timepicker/bootstrap-timepicker.min.css') !!}
{!! HTML::style('public/dist/plugins/camera/styles.css') !!}
@stop

@section('patient-content')
    <div class="nav-tabs-custom">
      @include('patients::partials.tab_nav')
      {!! Form::model($patient, array('class'=>'form-horizontal')) !!}

        <div class="tab-content">
          @include('patients::pages.forms.basic_info')
          @include('patients::pages.forms.location')
          @include('patients::pages.forms.allergies_alerts')
          @include('patients::pages.forms.notification_settings')
          @include('patients::pages.forms.photos')

        </div><!-- /.tab-content -->
        {!! Form::close() !!}
    </div>
@stop
