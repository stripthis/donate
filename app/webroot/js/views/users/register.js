$(function() {
	initStateDropdown();

	var rules = {
		'User.eula': {rule: 'required', message: 'Please accept the terms of conditions.'},
		'User.name': {rule: 'required', message: 'Please enter a name.'},
		'User.login': [
			{rule: 'required', message: 'Please enter your email address.'},
			{rule: 'email', message: 'Please enter a valid email address.'},
			{rule: 'remote', value: '/users/checkLogin', message: 'That email address has already been taken.'}
		],
		'User.password': [
			{rule: 'required', message: 'Please provide a password.'},
			{rule: 'minlength', value: 5, message: 'Your password must be at least 5 characters long.'}
		],
		'User.repeat_password': [
			{rule: 'required', message: 'Please provide a password.'},
			{rule: 'minlength', value: 5, message: 'Your password must be at least 5 characters long.'},
			{rule: 'equalTo', value: '#UserPassword', message: 'Please enter the same password as above.'}
		]
	}

	var $eulabox = $('form input[type=checkbox].required');
	observerEulaBox($eulabox, true);
	$eulabox.click(function(e) {
		observerEulaBox($(this));
	});
	$('span.terms').click(function() {
		observerEulaBox($eulabox);
	});

	$("#UserRegisterForm .submit input").click(function() {
		$('#UserRegisterForm .error-message').remove();

		success = $.validateCakeForm("UserRegisterForm", rules);
    
    if ($eulabox.length > 0) {
			var $errorbox = $eulabox.parent().parent().find('label.error2').remove();
			if (!$eulabox.is(':checked')) {
				$('<label></label>')
					.addClass('error2')
					.text('Please accept the terms of conditions!')
					.show()
					.insertAfter($eulabox.parent());
				return false;
			}
		}
		
    if (success) {
			$('#UserRegisterForm').submit();
		}
		return false;
	});
});

function observerEulaBox($obj, reset) {
	reset = reset || false;
	var val = '0'
	if (!reset) {
		val = $('#UserEula_').attr('value') == '1' ? '0' : '1';
	}
	$obj.attr('value', val);
	$('#UserEula_').attr('value', val);

	if (val == '1') {
		$obj.attr('checked', true);
	}
	if (val == '0') {
		$obj.attr('checked', false);
	}
}