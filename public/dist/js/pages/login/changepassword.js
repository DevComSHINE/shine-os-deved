// change password form validation
$('#ChangePassword').validate({
	rules: {
		password: {
			required: true,
			minlength: 6
		},
		verify_password: {
			equalTo: "#password",
			required: true,
			minlength: 6
		}
	}
});