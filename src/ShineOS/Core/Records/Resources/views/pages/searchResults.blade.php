@extends('layout.master')
@section('title') ShineOS+ || Search @stop

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
                    <h3 class="box-title">Search found {{ count($patients) }} records for: {{ $searchkey }} </h3><span class="floatright"><a class="btn btn-primary" href="{{ url('records/search') }}">Search Again</a></span>
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
                          <th>Birthdate</th>
                          <th>Family Folder</th>
                          <th>Barangay</th>
                          <th class="nosort" width="247">&nbsp;</th>
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
                                  <td>{{ dateFormat($patient->birthdate, "M. d, Y") }}</d>
                                  <td>{{ $patient->last_name }}</td>
                                  <td>{{ getBrgyName($patient->barangay) }}</td>
                                  <td class="nosort">
                                       <div class="btn-group">
                                          <div class="btn-group">
                                              <a href="#" type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown"> Actions <span class="caret"></span></a>
                                              <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                                                <li><a href="{{ url('healthcareservices/add', [$patient->patient_id]) }}">Add Healthcare Visit</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="#" data-toggle="modal" data-target="#deathModal" class="red">Declare Dead</a></li>
                                              </ul>
                                          </div>
                                          <a href="{{ url('patients/view', [$patient->patient_id]) }}" type="button" class="btn btn-success btn-flat" title="Edit Patient"><i class="fa fa-pencil"></i> Edit</a>
                                          <a href="{{ route('patients.delete', [$patient->patient_id]) }}" type="button" class="btn btn-danger btn-flat" title="Delete Role"><i class="fa fa-trash-o"></i> Delete</a>
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
