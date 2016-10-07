@extends('layout.master')
@section('title') SHINE OS+ || Search @stop
@section('heads')
    <style>
        table.datatable tbody td {
            vertical-align: top;
        }
    </style>
@stop

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-search"></i>
      Search
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Search</li>
    </ol>
  </section>
@stop

@section('content')
    @if (Session::has('warning'))
        <div class="alert alert-dismissible alert-warning">
            <p>{{ Session::get('warning') }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Search found {{ count($patients) }} records {{ $searchkey }} </h3><span class="floatright"><a class="btn btn-warning" href="{{ url('records/search') }}">Search Again</a></span>
                </div><!-- /.box-header -->

                @if (Session::has('message'))
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">Ã—</button>
                        <p>{{ Session::get('message') }}</p>
                    </div>
                @endif

                @if (Session::has('warning'))
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">Ã—</button>
                        <p>{{ Session::get('warning') }}</p>
                    </div>
                @endif

                <div class="box-body table-responsive no-padding overflowx-hidden">
                  @if ($patients)
                  <table class="table table-hover datatable">
                      <thead>
                      <tr>
                          <th class="nosort" >&nbsp;</th>
                          <th>Patient Name</th>
                          <th>Gender</th>
                          <th>Age</th>
                          @if(isset($patients[0]->healthcareservicetype_id) AND $patients[0]->healthcareservicetype_id != NULL)
                              <th>Healthcare Service</th>
                              <th>Order</th>
                          @else
                          <th>Family Folder</th>
                          <th>Barangay</th>
                          @endif
                          @if(isset($patients[0]->healthcareservicetype_id) AND $patients[0]->healthcareservicetype_id != NULL)
                          <th class="nosort" width="260">&nbsp;</th>
                          @else
                          <th class="nosort" width="250">&nbsp;</th>
                          @endif
                      </tr>
                      </thead>
                      <tbody>
                          @foreach ($patients as $patient)
                              <tr>
                                  <?php
                                        $pic = "noimage_male.png";
                                        if($patient->photo_url) {
                                            $pic = $patient->photo_url;
                                        }
                                  ?>
                                  <td><div class='profile_image profile_image_list pat_img' style='background: url("{{ uploads_url() }}patients/{{$pic }}") no-repeat center center;'></div></td>
                                  <td><a href="{{ url('patients', [$patient->patient_id]) }}" class="" title="View Patient Dashboard">{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }}</a></td>
                                  <td>{{ $patient->gender }}</td>
                                  <td>{{ getAge($patient->birthdate) }}</td>
                                  @if(isset($patient->healthcareservicetype_id))
                                      <td>{{ $patient->healthcareservicetype_id }}</td>

                                      <td>
                                          @if(isset($patient->medicalorder_type))
                                          {{ strtoupper(getOrderTypeName($patient->medicalorder_type)) }}<br />
                                              @if(isset($patient->laboratory_test_type))
                                              {{ getLabName($patient->laboratory_test_type) }}
                                              @endif
                                              @if(isset($patient->generic_name))
                                              {{ $patient->generic_name }}
                                              @endif
                                          @endif
                                      </td>

                                  @else
                                  <td>{{ $patient->last_name }}</td>
                                  <td>{{ getBrgyName($patient->barangay) }}</td>
                                  @endif
                                  <td class="nosort">
                                       <div class="btn-group">
                                          <div class="btn-group">
                                              <a href="#" type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown"> Actions | <span class="caret"></span></a>
                                              <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                                                <?php $consuButton = "btn-shine-green"; ?>
                                                @if(isset($patient->disposition) AND $patient->disposition != NULL)
                                                <?php $consuButton = "btn-warning"; ?>
                                                <li><a href="{{ url('healthcareservices/add/'.$patient->patient_id.'/'.$patient->healthcareservice_id) }}">Add Follow-up Visit</a></li>
                                                <li role="separator" class="divider"></li>
                                                @endif
                                                <li><a href="#" data-toggle="modal" data-target="#deathModal" class="red">Declare Dead</a></li>
                                              </ul>
                                          </div>
                                          @if(isset($patient->healthcareservicetype_id) AND $patient->healthcareservicetype_id != NULL)
                                          <a href="{{ url('healthcareservices/edit/'.$patient->patient_id.'/'.$patient->hservice_id) }}" class="btn {{ $consuButton }} btn-flat">Consultation</a>
                                          @endif
                                          <a href="{{ url('patients/view', [$patient->patient_id]) }}" type="button" class="btn btn-success btn-flat" title="Edit Patient">Patient</a>
                                      </div>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  @else

                  @endif
              </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop
