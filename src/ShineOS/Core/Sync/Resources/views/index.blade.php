@extends('layout.master')

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-database"></i>
      SHINE OS+ Sync
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Sync</li>
    </ol>
  </section>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Syncing</h3>
            </div>
            <div class="box-body">
                <p>Please sync your records regularly so that your PHIE and DOH Reports are generated complete in SHINE OS+ Cloud.</p>
                <div class="progress progress-striped active" id="loader">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    </div>
                </div>
                <p id="info"></p>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <a class="btn btn-block btn-social btn-instagram" id="sync-to-cloud">
                            <i class="fa fa-cloud-upload"></i> Sync to Cloud
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-block btn-social btn-linkedin" id="sync-from-cloud">
                            <i class="fa fa-cloud-download"></i> Grab records from Cloud
                        </a>
                    </div>
                </div>

            </div><!-- /.box-body -->
          </div>
    </div>
</div>

@stop

@section('scripts')
<script>
$(function(){
    $('#loader').hide();

    $('#sync-to-cloud').on('click', function(e){
        e.preventDefault();

        $.ajax({
            url: '<?php site_url(); ?>sync/toCloud',
            type: "GET",
            beforeSend: function() {
                progressBar();
            },
            error: function() {
              $('#info').html('<p>An error has occurred</p>');
            },
            success: function(data) {
                console.log(data);
                progressBar(data);
            }
        });
    });

    $('#sync-from-cloud').on('click', function(e){
        e.preventDefault();

        $.ajax({
            url: '<?php site_url(); ?>sync/fromCloud',
            type: "GET",
            beforeSend: function() {
                progressBar();
            },
            error: function() {
              $('#info').html('<p>An error has occurred</p>');
            },
            success: function(data) {
                console.log(data);
                progressBar(data);
            }
        });
    });
});


function progressBar(data = null)
{
    var progress = setInterval(function() {
        $('#loader').show();
        var $bar = $('.progress-bar');

        if (data == 'success') {
            $('#loader').hide();
            clearInterval(progress);
            $('.progress').removeClass('active');
            $('#info').text('Sync Done.');
        }
        else if (data == 'Nothing to sync') {
            $('#loader').html('Nothing to sync');
            $('.progress').removeClass('active');
        }
        else{
            if($bar.width() < 1020 ) {
                $bar.width($bar.width()+40);
            } else {
                clearInterval(progress);
                $('#loader').hide();
                $('#info').text('Sync Done.');
            }
        }

    }, 800);
}
</script>
@stop
