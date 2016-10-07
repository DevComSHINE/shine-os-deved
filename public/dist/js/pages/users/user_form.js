$('.input-group-addon').popover();

$("[data-mask]").inputmask();

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
        password: {
            'required': true,
            'minlength': 4
        },
        password_confirm: {
            equalTo: "#password"
        },
        first_name: {
            'alphanumeric_spaces': true
        },
        last_name: {
            'alphanumeric_spaces': true
        },
        email: {

        }
    }
});
