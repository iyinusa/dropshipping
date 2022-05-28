/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Js Form
*/
//////////===== Dynamic Modal Pop-up ===/////////
$(".pop").click(function () {
	$(".modal").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});

	var pageTitle = $(this).attr('pageTitle');
	var pageName = $(this).attr('pageName');
	var pageSize = $(this).attr('pageSize');
	$(".modal").addClass(pageSize);
	$(".modal .modal-title").html(pageTitle);
	$(".modal .modal-body").html('<div class="row"><div class="text-center col-lg-12"><i class="fa fa-circle-o-notch fa-spin fa-4x"></i><br/> Content loading, please wait...</div></div>');
	$(".modal .modal-body").load(pageName);
	$(".modal").modal("show");
	$(".modal").modal({
		fadeDuration: 1000,
		fadeDelay: 0.3,
		backdrop: 'static',
		keyboard: false
	});

	// $(".chosen-select").chosen();
});