/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Profile
*/

$('.edit-account').on('click', function () {
	var type = $(this).attr('data-content');
	if (type == 'Edit Account') {
		$('.view').hide(200);
		$('.edit').show(200);
	} else {
		$('.edit').hide(200);
		$('.view').show(200);
	}
});