/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Load Cart
*/

$(function () {
	load_cart(); // load cart
	load_page_cart(); // on main cart page
});

function add_cart() {
	var id = $('#pdt_id').val();
	var name = $('#pdt_name').val();
	var img = $('#pdt_img').val();
	var amount = $('#pdt_amount').val();
	var qty = $('#cart-qty').val();

	$.ajax({
		url: base_url + 'cart/add',
		type: 'post',
		data: { id: id, name: name, img: img, amount: amount, qty: qty },
		success: function (data) {
			load_cart();
			load_page_cart();
		}
	});
}

function update_cart(id) {
	var qty = $('#qty' + id).val();

	$.ajax({
		url: base_url + 'cart/update/' + id,
		type: 'post',
		data: { qty: qty },
		success: function (data) {
			load_cart();
			load_page_cart();
		}
	});
}

function updates_cart(id) {
	var qty = $('#qtty' + id).val();

	$.ajax({
		url: base_url + 'cart/update/' + id,
		type: 'post',
		data: { qty: qty },
		success: function (data) {
			load_cart();
			load_page_cart();
		}
	});
}

function remove_cart(id) {
	$.ajax({
		url: base_url + 'cart/remove/' + id,
		success: function (data) {
			load_cart();
			load_page_cart();
		}
	});
}

function load_cart() {
	$.ajax({
		url: base_url + 'cart/load',
		success: function (data) {
			var da = JSON.parse(data);
			$('.cart-box').html(da.msg);
			if (da.count > 0) {
				$('.is-cart').show(500);
				$('.cart-count').html(da.count);
			} else {
				$('.is-cart').hide(500);
			}
		}
	});
}

function load_page_cart() {
	$.ajax({
		url: base_url + 'cart/load_page_cart',
		success: function (data) {
			var dx = JSON.parse(data);
			$('.cart-page').html(dx.content);
		}
	});
}