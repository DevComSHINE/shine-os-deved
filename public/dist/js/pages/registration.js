$('.for_government').fadeOut();
$('#newUser').fadeOut();
$('#oldUser').fadeOut();

$('.input-group-addon').popover();

$("[data-mask]").inputmask();

// refresh captcha image
$('.captcha-refresh').on('click.captcha-refresh', function () {
    var captchaUrl = $('#captcha-image').attr('src');
    var d = new Date();
    var newUrl = captchaUrl+'?'+d.getTime();

    $('#captcha-image').attr('src', newUrl);
    return false;
});

/* additional validation(s)
$.validator.addMethod("phic_accr_id_validator", function(value, element) {
    return this.optional(element) || /^[-0-9\s]+$/i.test(value);
}, "Must be numbers, dashes and spaces only");
$.validator.addMethod("alphanumeric_spaces", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-z0-9\-\s]+$/i);
}, "Must be letters, numbers, and spaces only.");
$.validator.addMethod("numbers_dashes", function(value, element) {
    return this.optional(element) || value == value.match(/^\d+(-\d+)*$/);
}, "Numbers and dashes only.");*/

// if there's a DOH Code, owner type is automatically set to "government"
var DOH_facility_code = $('#DOH_facility_code');
DOH_facility_code.on('blur.DOH_facility_code', function () {
    var dohCode = $(this).val();
    var ownership_type = $('#ownership_type');

    if ( dohCode != '' ) {
        ownership_type.val('government');
    } else {
        ownership_type.val('');
    }

    // upon change, autofill the registration form
    prefillRegistration();
});

// ownership type dependencies
var ownership_type = $('.regbtn');
ownership_type.on('click', function () {
    var selval = $(this).find('input').val();
    if ( selval == 'government' ) {
        $('.ot_private').fadeOut();
        $('.ot_government').fadeIn();
        $('.for_government').fadeIn();
        $('#DOH_facility_code').addClass('required');
    } else if ( selval == 'private' ) {
        $('.ot_private').fadeIn();
        $('.ot_government').fadeOut();
        $('.for_government').fadeOut();
        $('#DOH_facility_code').removeClass('required');
    } else {
        $('.ot_private').fadeIn();
        $('.ot_government').fadeIn();
        $('.for_government').fadeOut();
        $('#DOH_facility_code').removeClass('required');
    }
});

// ownership type dependencies
var account_type = $('.acctbtn');
account_type.on('click', function () {
    var selval = $(this).find('input').val();
    if ( selval == 'existing' ) {
        $('#newUser').attr('disabled','disabled').fadeOut();
        $('#oldUser').removeAttr('disabled').fadeIn();
    } else if ( selval == 'new' ) {
        $('#newUser').removeAttr('disabled').fadeIn();
        $('#oldUser').attr('disabled','disabled').fadeOut();
    }
});

// prefill registration form based on DOH Code
function prefillRegistration () {
    var result = $.ajax({
        url: "registration/check_doh_code",
        type: "post",
        cache: false,
        async: false,
        data: {
            "doh_code" : $('input[name="DOH_facility_code"]').val(),
            "_token" : $('input[name="_token"]').val()
        },
        success: function(response) {
            var result = jQuery.parseJSON(response);

            if ( result.flag_result == true ) {
                var result_info = result.result;
                $('#facility_name').val(result_info.name);
                $('[name=provider_type]').val('facility');
                $('[name=facility_type]').val(result_info.type);
                $('#phic_accr_id').attr('required','required');
                $('#phic_accr_id').addClass('required');

                $('[name=facility_barangay]').val(result_info.barangay);
                $('[name=facility_city]').val(result_info.city);
                $('[name=facility_province]').val(result_info.province);
                $('[name=facility_region]').val(result_info.region);

                $('form')
                    .formValidation('revalidateField', '#facility_name')
                    .formValidation('revalidateField', '[name=provider_type]')
                    .formValidation('revalidateField', '[name=facility_type]')
                    .formValidation('revalidateField', '#phic_accr_id');
            }

        }
    });
}

// refresh catpcha the moment submit button is clicked
var btnRegister = $('#btnRegister');
btnRegister.on('click.btnRegister', function () {
    $('.captcha-refresh').click();
});
