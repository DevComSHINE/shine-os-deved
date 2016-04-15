$('.for_government').fadeOut();

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

// additional validation(s)
$.validator.addMethod("phic_accr_id_validator", function(value, element) {
    return this.optional(element) || /^[-0-9\s]+$/i.test(value);
}, "Must be numbers, dashes and spaces only");
$.validator.addMethod("alphanumeric_spaces", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-z0-9\-\s]+$/i);
}, "Must be letters, numbers, and spaces only.");
$.validator.addMethod("numbers_dashes", function(value, element) {
    return this.optional(element) || value == value.match(/^\d+(-\d+)*$/);
}, "Numbers and dashes only.");

// form validation
$('#crudForm').validate({
    rules: {
        DOH_facility_code: {
            required: function(element) {
                return $("#ownership_type").val() == 'government';
            }
        },
        facility_code : {
            'required': true,
            //'facility_code_regex': /^[DOH0-9]+$/i
        },
        password: {
            'required': true,
            'minlength': 4
        },
        password_confirm: {
            equalTo: "#password"
        },
        phic_accr_id: {
            'phic_accr_id_validator': true
        },
        first_name: {
            'alphanumeric_spaces': true
        },
        last_name: {
            'alphanumeric_spaces': true
        },
        mobile: {
            'required': true,
            //'numbers_dashes': true
        },
        test_captcha : {
            required: true,
            remote: {
                url: "registration/check_captcha",
                type: "post",
                cache: false,
                async: false,
                data: {
                    "captcha" : function () {
                        return $('input[name="test_captcha"]').val();
                    },
                    "_token" : $('input[name="_token"]').val()
                },
                dataFilter: function(response) {
                    return response;
                }
            }
        }
    },
    onkeyup: false,
    messages: {
        test_captcha: {
            "remote": "Invalid captcha."
        }
    }
});

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
                $('#facility_name').val(result_info.name);
                $('[name=provider_type]').val('facility');
                $('[name=facility_type]').val(result_info.type);
                $('#phic_accr_id').attr('required','required');
                $('#phic_accr_id').addClass('required');
            }

        }
    });
}

// refresh catpcha the moment submit button is clicked
var btnRegister = $('#btnRegister');
btnRegister.on('click.btnRegister', function () {
    $('.captcha-refresh').click();
});
