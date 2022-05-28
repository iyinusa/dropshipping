/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: http://iyinusa.kenafftech.com
* Module/App: Js Form
*/

$(function () {
	"use strict";

	// Get the form.
	var form = $('#bb_ajax_form');
	var form2 = $('#bb_ajax_form2'); // to allow 2 forms on a page

	// Get the messages div.
	var formMessages = $('#bb_ajax_msg');
	var formMessages2 = $('#bb_ajax_msg2'); // to allow 2 forms on a page

	// Set up an event listener for the contact form.
	$(form).unbind('submit'); // prevent multiple submit
	$(form).submit(function (event) {
		// Stop the browser from submitting the form.
		event.preventDefault();

		// scroll to top for notification display
		$('html, body').animate({
			scrollTop: form.offset().top
		}, 1000);

		// disable submit button
		var formBtn = $('.bb_form_btn');
		formBtn.attr('disabled', 'disabled');

		// Serialize the form data.
		//var formData = $(form).serializeArray();
		var formData = new FormData($(this)[0]);
		var clear = $(form).attr('clear');

		// show prograss loading
		$(formMessages).html('<div class="text-center col-sm-12 form_alert"><i class="fa fa-circle-o-notch fa-spin"></i> please wait...</div>');

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			dataType: 'html',
			data: formData,
			processData: false,
			contentType: false,
			async: false
		}).done(function (msg) {
			// Set the message text.
			$(formMessages).html(msg);
			if (clear == true) {
				form.get(0).reset(); // clear all form data
			}
			formBtn.removeAttr('disabled');
		}).fail(function (data) {
			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured, please check your internet connectivity.');
			}
		});
	});

	// do this for second form
	$(form2).unbind('submit'); // prevent multiple submit
	$(form2).submit(function (event) {
		// Stop the browser from submitting the form.
		event.preventDefault();

		// scroll to top for notification display
		$('html, body').animate({
			scrollTop: form.offset().top
		}, 1000);

		// disable submit button
		var formBtn = $('.bb_form_btn');
		formBtn.attr('disabled', 'disabled');

		// Serialize the form data.
		//var formData = $(form).serializeArray();
		var formData = new FormData($(this)[0]);
		var clear = $(form).attr('clear');

		// show prograss loading
		$(formMessages2).html('<div class="text-center col-sm-12 form_alert"><i class="fa fa-circle-o-notch fa-spin"></i> please wait...</div>');

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form2).attr('action'),
			dataType: 'html',
			data: formData,
			processData: false,
			contentType: false,
			async: false
		}).done(function (msg) {
			// Set the message text.
			$(formMessages2).html(msg);
			if (clear == true) {
				form.get(0).reset(); // clear all form data
			}
			formBtn.removeAttr('disabled');
		}).fail(function (data) {
			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages2).text(data.responseText);
			} else {
				$(formMessages2).text('Oops! An error occured, please check your internet connectivity.');
			}
		});
	});
});