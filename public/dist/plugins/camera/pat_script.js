$(document).ready(function(){

    var camera = $('#camera'),
        photos = $('#photos'),
        screen =  $('#screen');
        url = 'http://ajwcc/shineoslaravel2/public/dist/plugins/camera/';

    var template = '<a href="uploads/original/{src}" rel="cam" '
        +'style="background-image:url(uploads/thumbs/{src})"></a>';

    /*----------------------------------
        Setting up the web camera
    ----------------------------------*/

    webcam.set_swf_url(url+'webcam.swf');
    //webcam.set_api_url('/emr/file/do_upload/profiles');	// The upload script
    webcam.set_quality(90);								// JPEG Photo Quality
    webcam.set_shutter_sound(true, url+'shutter.mp3');

    // Generating the embed code and adding it to the page:
    screen.html(
        webcam.get_html(520, 370)
    );


    /*----------------------------------
        Binding event listeners
    ----------------------------------*/


    var shootEnabled = false;

    $('#shootButton').click(function(){

        if(!shootEnabled){
            return false;
        }

        webcam.freeze();
        togglePane();
        return false;
    });

    $('#cancelButton').click(function(){
        webcam.reset();
        togglePane();
        return false;
    });

    $('#uploadButton').click(function(){
        webcam.upload();
        webcam.reset();
        //togglePane();
        return false;
    });

    camera.find('.settings').click(function(){
        if(!shootEnabled){
            return false;
        }

        webcam.configure('camera');
    });

    // Showing and hiding the camera panel:

    var shown = false;
    $('.camTop').click(function(){

        $('.tooltip').fadeOut('fast');

        if(shown){
            camera.animate({
                bottom:-466
            });
        }
        else {
            camera.animate({
                bottom:-5
            },{easing:'easeOutExpo',duration:'slow'});
        }

        shown = !shown;
    });

    $('.tooltip').mouseenter(function(){
        $(this).fadeOut('fast');
    });


    /*----------------------
        Callbacks
    ----------------------*/


    webcam.set_hook('onLoad',function(){
        // When the flash loads, enable
        // the Shoot and settings buttons:
        shootEnabled = true;
    });

    webcam.set_hook('onComplete', function(msg){

        // This response is returned by upload.php
        // and it holds the name of the image in a
        // JSON object format:
        $.fancybox.close();

        msg = $.parseJSON(msg);

        if(msg.error){
            alert(msg.message);
        }
        else {
            // Adding it to the page;
            $('#pat_img').css('background-image','url("'+url+msg.filename+'")' );
            $('#pat_hid').val( msg.filename );
        }
    });

    webcam.set_hook('onError',function(e){
        screen.html(e);
    });

    /*----------------------
        Helper functions
    ------------------------*/


    // This function initializes the
    // fancybox lightbox script.

    function initFancyBox(filename){
        photos.find('a:visible').fancybox({
            'transitionIn'	: 'elastic',
            'transitionOut'	: 'elastic',
            'overlayColor'	: '#111'
        });
    }


    // This function toggles the two
    // .buttonPane divs into visibility:

    function togglePane(){
        var visible = $('#camera .buttonPane:visible:first');
        var hidden = $('#camera .buttonPane:hidden:first');

        visible.fadeOut('fast',function(){
            hidden.show();
        });
    }


    // Helper function for replacing "{KEYWORD}" with
    // the respectful values of an object:

    function templateReplace(template,data){
        return template.replace(/{([^}]+)}/g,function(match,group){
            return data[group.toLowerCase()];
        });
    }
});
