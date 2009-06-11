$(function() {
/**
 * Cake SQL Log (app debug mode)
 */
	if ($('.cake-sql-log').length > 0) {
		$('.cake-sql-log').hide();
		$('<a href="#">Toggle Sql Log</a>')
			.insertBefore($('.cake-sql-log'))
			.click(function() {
				$('.cake-sql-log').toggle();
				return false;
			});
	}
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
	$('.hint').hint();
/**
 * Slick annimation -  Slide, fade and toggle (and make cofee if you're nice)
 */
	jQuery.fn.slideFadeToggle = function(speed, easing, callback) {
		return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback); 
	};
/** 
 * Toogles
 * How it works: a.toggle#<id> closes/open .toggle_wrapper#wrapper_<id> easy hey ?
 */
	$(".toggle.close").each(function() {
		$(".toggle_wrapper#wrapper_"+$(this).attr("id")).hide();
	})

	$('a.toggle').click(function() {
		$(".toggle_wrapper#wrapper_"+$(this).attr("id")).slideFadeToggle(300);
		if($('a.toggle#'+$(this).attr("id")).hasClass("close")) {
			$('a.toggle#'+$(this).attr("id")).addClass("open").removeClass("close");
		} else {
			$('a.toggle#'+$(this).attr("id")).addClass("close").removeClass("open");
		}
		return false;
	});
});