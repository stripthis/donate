/**
 * Hint for input fields (text)
 * @credit http://remysharp.com/2007/01/25/jquery-tutorial-text-box-hints/
 */
$.fn.hint = function (blurClass) {
	if (!blurClass) {
		blurClass = 'blur';
	}
	return this.each(function () {
		var $$ = $(this);
		var title = $$.attr('title');
		if (title) {
			$$.blur(function () {
				if ($$.val() == '') {
					$$.val(title).addClass(blurClass);
				}
			})
			.focus(function () {
				if ($$.val() == title && $$.hasClass(blurClass)) {
					$$.val('').removeClass(blurClass);
				}
			})
			.parents('form:first').submit(function () {
				if ($$.val() == title && $$.hasClass(blurClass)) {
					$$.val('').removeClass(blurClass);
				}
			}).end()
			.blur();
			if ($.browser.mozilla && !$$.attr('autocomplete')) {
				setTimeout(function () {
					if ($$.val() == title) $$.val('');
					$$.blur();
				}, 10);
			}
		}
	});
};