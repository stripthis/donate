$(function() {
	resizing();

	$('a.add-step').click(function() {
		var newId = $('fieldset.steps textarea').length > 0
					? parseInt($('fieldset.steps textarea:last').attr('rel')) + 1
					: 1;

		var $textarea = $(
			'<div class="input textbox">' +
				'<label for="step' + newId + '">Step ' + newId + ':</label>' +
				'<textarea id="step' + newId +'" rel="' + newId + '" rows="6" cols="30" name="data[step]['+ newId + ']"/>' +
			'</div>'
		);

		$textarea.insertBefore($(this));
		resizing();

		return false;
	});

	function resizing() {
		$('#template_form textarea')
			.unbind('focus')
			.focus(function() {
				$(this).attr('rows', '18');
			})
			.unbind('blur')
			.blur(function() {
				$(this).attr('rows', '6');
			});
	}
});