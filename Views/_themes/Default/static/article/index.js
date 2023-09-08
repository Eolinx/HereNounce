$(document).on('click', '#app-article-index-comment-actions .quark-button[data-article-ratio]', function (e) {
	e.preventDefault();

	var button = $(this),
		form = $('#app-article-index-comment'),
		action = button.data('article-ratio');

	form.find('.quark-button[data-article-ratio]').removeClass('active');
	button.addClass('active');

	form.find('[name="article_ratio_action"]').val(action);
});