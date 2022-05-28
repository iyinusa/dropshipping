/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Find Product
*/

$('.is-product-input').on('input', function () {
	var input = $(this).val();
	$('.is-product-input').val(input);
});

$('.is-find-product').on('click', function () {
	$(this).addClass('is-loading');
	var text = $('.is-product-input').val();

	$.ajax({
		url: base_url + 'shop/find_product',
		type: 'post',
		data: { text: text },
		success: function (data) {
			var dt = JSON.parse(data);
			$('.is-product-msg').html(dt.msg);
			$('.is-find-product').removeClass('is-loading');

			if (dt.status == true) {
				$('.is-product-input').val('');
				// window.location.replace(base_url + 'shop/product/' + dt.id);
				window.location.replace(base_url + 'shop/search/');
			}
		}
	});
});