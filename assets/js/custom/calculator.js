/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Shipping Calculator
*/

$(function () {

});

function calc() {
	var currency = $('#currency').val();
	var cost = $('#cost').val();
	var quantity = $('#quantity').val();
	var weight = $('#weight').val();

	$.ajax({
		url: base_url + 'calculator/compute',
		type: 'post',
		data: { currency: currency, cost: cost, quantity: quantity, weight: weight },
		success: function (data) {
			var dt = JSON.parse(data);

			$('#curr').html(dt.amount);
			$('#curr_info').html(dt.converse);
		}
	});
}