@extends('updates::index')
@section('header-content') <i class="fa fa-cloud-download"></i> ShineOS+ Updates @stop
@section('list-content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title text-shine-blue"> <i class="fa fa-refresh"></i> Checking Updates</h3>
        <small><em></em></small>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->

    <div class="box-body">
        <div id="update-box">xx</div>
    </div><!-- /.box-body -->

    <div class="box-footer text-center">

    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var version = '<?php echo Config::get('config.version'); ?>';
        var vercomp = '<?php echo str_replace(".", "", Config::get('config.version')); ?>';
        var verdate = '<?php echo Config::get('config.date'); ?>';
        $.ajax({
            headers: {
                "Access-Control-Allow-Origin":"*",
                "Access-Control-Allow-Credentials":"true",
                "Content-Type": "application/json; charset=utf-8"
            },
            xhrFields: {
                withCredentials: false
            },
            type: "GET",
            async: false,
            crossDomain: true,
            url : "http://10.11.82.25/core-update/update-api.php",
            dataType: 'jsonp',
            contentType: 'application/json',
            jsonpCallback: 'callback',
            beforeSend: function( xhr ) {
                $('#update-box').html("Checking for updates. Please wait...");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            },
            success: function(data) {
                var text = '';
                var len = data.length;
                for(var i=0;i<len;i++){
                    entry = data[i];
                    //check for current update & version
                    //let us parse filename
                    fn = entry.filename.split("-");
                    newver = fn[2].slice(0, -4);
                    if(fn[1] != verdate && newver != version) {
                        text += '<p>' + entry.filename + '</p>';
                    }
                }
                if(text != '') {
                    $('h3.box-title').html('<i class="fa fa-exclamation-triangle"></i> A new version of ShineOS+ is available.');
                    $('#update-box').html("<p>Version "+newver+" is available. You need to update your ShineOS+.</p><p><a href='' class='btn btn-primary'>Update Now</a></p>");
                } else {
                    $('h3.box-title').html('<i class="fa fa-thumbs-o-up"></i> You have the latest version of ShineOS+.');
                    $('#update-box').html("<p>If you need to re-install version "+version+", you can do so here or download the package and re-install manually:</p>");
                }
            }
        });

    });
</script>
@stop
