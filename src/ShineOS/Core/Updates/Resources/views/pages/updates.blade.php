@extends('updates::index')
@section('header-content') <i class="fa fa-refresh"></i> ShineOS+ Updates @stop

@section('list-content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title text-shine-blue"> <i class="fa fa-refresh fa-spin"></i> Checking Updates</h3>
        <small><em></em></small>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->

    <div class="box-body">
        <div id="update-box">xx</div>
        <iframe name="updatingwindow" style="border: 0; width: 100%; height: 390px;"></iframe>
    </div><!-- /.box-body -->

    <div class="box-footer text-center">

    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var version = '<?php echo Config::get('config.version'); ?>';
        var verdate = '<?php echo Config::get('config.date'); ?>';
        var server = '<?php echo getenv('CLOUDIP'); ?>';
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
            url : "http://"+server+"/upgrades/update-api.php",
            dataType: 'jsonp',
            contentType: 'application/json',
            jsonpCallback: 'callback',
            beforeSend: function( xhr ) {
                $('#update-box').html("<p><i class='fa fa-spinner fa-pulse'></i> Checking for updates. Please wait...</p>");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#update-box').html("<p>Opps. Something went wrong. Try again later.</p>");
            },
            success: function(data) {
                var text = '';
                var len = data.length;
                for(var i=0;i<len;i++){
                    entry = data[i];
                    //check for current update
                    fn = entry.filename.split("-");
                    newver = fn[2].slice(0, -4);
                    if(fn[1] != verdate && newver != version) {
                        var url = "{{ url('updates/coreupdate') }}/" + fn[1] + "/" + newver;
                    } else {
                        var url = '';
                    }
                }

                if(url != '') {
                    $('h3.box-title').html('<i class="fa fa-exclamation-triangle"></i> A new version of ShineOS+ is available.');
                    $('#update-box').html("<p>Version "+newver+" is available. You need to update your ShineOS+.</p><p><a href='"+url+"' class='btn btn-primary' target='updatingwindow'>Update Now</a></p>");
                } else {
                    $('h3.box-title').html('<i class="fa fa-thumbs-o-up"></i> You have the latest version of ShineOS+.');
                    $('#update-box').html("<p>If you need to re-install version "+version+", you can do so here or download the package and re-install manually:</p>");
                }
            }
        });

    });
</script>
@stop
