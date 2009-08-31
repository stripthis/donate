/**
 * launch browser add to favorite dialog
 */
function addFavorite(){
  var title=document.title; var url=location.href;               // default page url and title
  if(window.sidebar) window.sidebar.addPanel(title, url, "");    // firefox
  else if(document.all) window.external.AddFavorite(url, title); // evil
  else if(window.opera && window.print){                         // opera
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
 * Slick annimation -  Slide, fade and toggle (and will break your tables if you're nice)
 */
	jQuery.fn.slideFadeToggle = function(speed, easing, callback) {
		return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback); 
	};
/** 
 * Toogles
 * How it works: a.toggle#<id> closes/open .toggle_wrapper#wrapper_<id>
 * OR  a.toggle#<id> closes/open .toggle_wrapper.wrapper_<id> easy hey ?
 */
	$(".toggle.close").each(function() {
		$(".toggle_wrapper#wrapper_"+$(this).attr("id")).hide();
		$(".toggle_wrapper.wrapper_"+$(this).attr("id")).hide();
	})

	$('a.toggle').click(function() {
		//@todo annimation only if not table row...
		//$(".toggle_wrapper#wrapper_"+$(this).attr("id")).slideFadeToggle(300);
		if($('a.toggle#'+$(this).attr("id")).hasClass("close")) {
			$('a.toggle#'+$(this).attr("id")).addClass("open").removeClass("close");
			$(".toggle_wrapper#wrapper_"+$(this).attr("id")).show();
		} else {
			$('a.toggle#'+$(this).attr("id")).addClass("close").removeClass("open");
			$(".toggle_wrapper#wrapper_"+$(this).attr("id")).hide();
		}
		return false;
	});

	/**
	 * Form select/unselect all
	 */
	$('input.select_all').click(function(){
		var check = false;
		if($(this).attr("checked")!= undefined && $(this).attr("checked")){
			check = true;
		}
		$("input[name=" + $(this).attr('name') + "]").each(function(){
			this.checked = check;
		})
	});
});