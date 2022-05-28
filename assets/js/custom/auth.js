/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Auth
*/

$('.is-tab').on('click', function () {
	$('#msg').html('');
	$('.is-login').removeClass('is-loading');
	$('.is-register').removeClass('is-loading');
});

$('.is-login').on('click', function () {
	$('#msg').html('<i class="fa fa-spin fa-spinner"></i> processing...');
	$(this).addClass('is-loading');

	var email = $('#email').val();
	var password = $('#password').val();

	$.ajax({
		url: base_url + 'auth/ajax/login',
		type: 'post',
		data: { email: email, password: password },
		success: function (data) {
			$('.is-login').removeClass('is-loading');

			var dt = JSON.parse(data);
			$('#msg').html(dt.msg);

			if (dt.status == true) {
				$('input').val('');
				window.location.replace(base_url + dt.redirect);
			}
		}
	});
});

$('.is-register').on('click', function () {
	$('#msg').html('<i class="fa fa-spin fa-spinner"></i> processing...');
	$(this).addClass('is-loading');

	var firstname = $('#reg_firstname').val();
	var lastname = $('#reg_lastname').val();
	var email = $('#reg_email').val();
	var password = $('#reg_password').val();
	var confirm = $('#reg_confirm').val();
	var agent = $('#is_agent');
	if (agent.prop('checked')) { agent = 1; } else { agent = 0; }

	$.ajax({
		url: base_url + 'auth/ajax/register',
		type: 'post',
		data: { firstname: firstname, lastname: lastname, email: email, password: password, confirm: confirm, agent: agent },
		success: function (data) {
			$('.is-register').removeClass('is-loading');

			var dt = JSON.parse(data);
			$('#msg').html(dt.msg);

			if (dt.status == true) {
				$('input').val('');
			}
		}
	});
});