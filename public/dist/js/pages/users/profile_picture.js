// validation
$('#crudForm').validate();

// disabled account
var disableAccount = $('.disabled-account');
disableAccount.on('click.disableAccount', function () {
	var disableLink = $(this).attr('data-disableaccount');
	window.location = disableLink;
	return false;
});

// change password form validation
$('#ChangePassword').validate({
	rules: {
		currentPassword: 'required',
		newPassword: {
			required: true,
			minlength: 6
		},
		confirmPassword: {
			equalTo: "#newPassword",
			required: true,
			minlength: 6
		}
	}
});