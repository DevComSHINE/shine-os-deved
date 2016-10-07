@extends('reminders::layouts.master')

@section('reminders-content')
    <div class="col-md-9">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"> Reminders </h3>
          </div><!-- /.box-header -->
          @if (Session::has('flash_message'))
            <div class="alert {{Session::get('flash_type') }} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('flash_message') }}
              </div>
          @endif
          <div class="box-body table-responsive overflowx-hidden">
              <table class="table table-hover datatable">
                  <thead>
                    <tr>
                        <th> Recipient </th>
                        <th> Subject </th>
                        <th> Appointment </th>
                        <th> Days to Notify </th>
                        <th> Status </th>
                        <th> Modified </th>
                        <th> Action </th>
                    </tr>
                  </thead>
                  <tbody>
                      @if($join)
                        @foreach($join as $key => $value)
                      <tr>
                        <td>
                          {{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }}
                        </td>
                        <td>
                          {{ $value->reminder_subject }}
                        </td>
                        <td>
                          {{ date('M d, Y', strtotime($value->appointment_datetime)) }}
                        </td>
                        <td>
                          {{ $value->daysbeforesending }}
                        </td>
                        <td>
                          {{ $value->sent_status }}
                        </td>
                        <td>
                          {{ $value->updated_at }}
                        </td>
                        <td class="nosort">
                          <a href="{{ url('reminders/delete', [$value->reminder_id]) }}" class="btn btn-default btn-flat"> <i class="fa fa-trash-o"></i> Delete </a>
                        </td>
                      </tr>
                        @endforeach
                      @endif
                  </tbody>
              </table>
          </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
@stop
