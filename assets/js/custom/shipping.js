/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Shipping
*/

$(function () {
	ini_load();
});

function ini_load(x, y) {
	var more = 'no';
	var methods = '';
	if (parseInt(x) > 0 && parseInt(y) > 0) {
		more = 'yes';
		methods = x + '/' + y + '/';
	}

	if (more == 'no') {
		$('#load_data').html('<div class="column is-12"><h1 class="has-text-gray" style="text-align:center;"><i class="fa fa-spin fa-circle-o-notch fa-4x"></i></h1></div>');
	} else {
		$('#loadmore').html('<div class="column is-12"><h1 class="has-text-gray" style="text-align:center;"><i class="fa fa-spin fa-circle-o-notch fa-4x"></i></h1></div>');
	}

	var param;

	var sea = $('#search_query').val();
	// var statuss = $('#order_status').val();

	if (sea != '' && sea != 'undefined') { param = '?search=' + sea; } else { param = '?search=null'; }
	// if (statuss != '' && statuss != 'undefined') { param = param + '&status=' + statuss; }

	$.ajax({
		url: base_url + 'admin/shipping_directory/' + methods + param,
		success: function (data) {
			var dt = JSON.parse(data);
			if (more == 'no') {
				$('#load_data').html(dt.item);
			} else {
				$('#load_data').append(dt.item);
			}

			if (dt.offset > 0) {
				$('#loadmore').html('<a href="javascript:;" class="btn btn-default is-rounded" onclick="ini_load(' + dt.limit + ', ' + dt.offset + ');"><i class="fa fa-reload"></i> Load More</a>');
			} else {
				$('#loadmore').html('');
			}

			$.getScript(base_url + 'assets/js/jsmodal.js');
		}
	});
}