$(function () {
	var localized = new Quark.Controls.LocalizedInput('.localized');

	var upload = new Quark.Controls.File('.upload-trigger', {
		success: function (response, trigger) {
			var file = trigger.parents('.quark-input'),
				file_target = file.find('input'),
				file_preview = file.find('.upload-preview');

			file_target.val(response.resource.resource);
			file_preview.css('background-image', 'url(' + response.resource.url + ')');
		}
	});
});

$(document).on('click', '#app-header-mobile .quark-button', function (e) {
	e.preventDefault();

	var header = $('#app-header');

	if (header.hasClass('mobile-visible')) header.removeClass('mobile-visible');
	else header.addClass('mobile-visible');
});