/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Checkout
*/

$(function () {

});

function select_agent(id, amount) {
	$('#agent_id').val(id);
	$('#agent_amount').val(amount);
}

function submit_shipping() {
	$('.is-next').addClass('is-loading');

	var agent_id = $('#agent_id').val();
	var agent_amount = $('#agent_amount').val();
	var number = $('#number').val();
	var street = $('#street').val();
	var postal = $('#postal').val();
	var city = $('#city').val();
	var country_id = $('#country_id').val();
	var state_id = $('#state_id').val();

	$.ajax({
		url: base_url + 'checkout/submit_shipping',
		type: 'post',
		data: { agent_id: agent_id, agent_amount: agent_amount, number: number, street: street, postal: postal, city: city, country_id: country_id, state_id: state_id },
		success: function (data) {
			var cdt = JSON.parse(data);
			$('.is-next').removeClass('is-loading');
			$('#checkout_msg').html(cdt.msg);

			if (cdt.status == true) {
				window.location.replace(base_url + cdt.redirect);
			}
		}
	});
}

function submit_order() {
	$('.is-next').addClass('is-loading');

	$.ajax({
		url: base_url + 'checkout/submit_order',
		success: function (data) {
			var cdt = JSON.parse(data);
			$('.is-next').removeClass('is-loading');
			$('#checkout_msg').html(cdt.msg);

			if (cdt.status == true) {
				window.location.replace(base_url + cdt.redirect);
			}
		}
	});
}

function wallet_pay() {
	$('.is-next').addClass('is-loading');

	$.ajax({
		url: base_url + 'checkout/wallet_pay',
		success: function (data) {
			var cdt = JSON.parse(data);
			$('.is-next').removeClass('is-loading');
			$('#checkout_msg').html(cdt.msg);

			if (cdt.status == true) {
				window.location.replace(base_url + cdt.redirect);
			}
		}
	});
}