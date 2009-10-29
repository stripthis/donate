/**
 * launch browser add to favorite dialog
 */
function addFavorite(){
	var title = document.title;
	var url = location.href;
	if (false && window.sidebar) {
		window.sidebar.addPanel(title, url, "");
	} else if (document.all) {
		alert('here');
		window.external.AddFavorite(url, title);
	} else if (window.opera && window.print) {
		var box = document.createElement('a');
		box.setAttribute('href',url); box.setAttribute('title',title); box.setAttribute('rel','sidebar');
		box.click();
	}
}

/**
 * launch browser print dialog
 */
function printThis(){
  if(window.print) window.print();  
  else{
    var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
    document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
    WebBrowser1.ExecWB(6, 2);  
    WebBrowser1.outerHTML = "";  
  }
}

/**
 * MAIN (JQUERY) - on document ready
 */
$(function() {
	var saveWidgetsText = $('a.save-widgets').text();
	$('a.save-widgets').click(function() {
		var self = this;
		var url = '/admin/widget_states/save';
		var widgets = [];
		$('#right_sidebar div.widget').each(function() {
			var myClass = $(this).attr('class');
			widgets.push(myClass.replace(/(widget|open|closed| )/ig, ''));
		});

		var data = [];
		for (var type in widgets) {
			var val = $('#right_sidebar .widget.' + widgets[type]).is('.open') ? '1' : '0';
			data.push(widgets[type] + '=' + val);
		};

		$.postCake(url, data.join('&'), function() {
			$(self).text('Saved!');
		});
		return false;
	});

	$('.donate-submit').click(function() {
		$(this)
			.attr('value', 'Processing ..')
			.attr('disabled', true);
	});
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
 * Slick annimation -  Slide, fade and toggle (and will break your tables if you're nice)
 */
	jQuery.fn.slideFadeToggle = function(speed, easing, callback) {
		return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback); 
	};
/** 
 * Toogles
 * How it works: a.toggle#<id> closes/open .wrapper_<id> easy hey ?
 */
	$(".toggle.closed").each(function() {
		$(".wrapper_"+$(this).attr("id")).hide();
	})

	$('a.toggle').click(function() {
		if ($('a.toggle#'+$(this).attr("id")).hasClass("closed")) {
			$('a.toggle#'+$(this).attr("id")).addClass("open").removeClass("closed");
			$('a.toggle#'+$(this).attr("id")).parents('.widget').addClass("open").removeClass("closed");
			$(".wrapper_"+$(this).attr("id")).show();
		} else {
			$('a.toggle#'+$(this).attr("id")).addClass("closed").removeClass("open");
			$('a.toggle#'+$(this).attr("id")).parents('.widget').addClass("closed").removeClass("open");
			$(".wrapper_"+$(this).attr("id")).hide();
		}
		$('#right_sidebar a.save-widgets').text(saveWidgetsText);
		return false;
	});
/**
 * Form select/unselect all
 * How it works: 
 */
	$('input.select_all').click(function() {
		var check = false;
		if($(this).attr("checked")!= undefined && $(this).attr("checked")){
			check = true;
		}
		$('input[type=checkbox]', $(this).parents('table')).each(function(){
			this.checked = check;
		})
	});
});
