/**
 * Drop down menu interactions
 * Hide and show submenu when pressing arrow down button
 * Acts like a dropdown list as far as the user interaction goes
 */
$(function() {
	var _visible = false;
	var _img = null;
	var _subitem = null;
	
	/***
	 * Hide / show
	 */
	function hide(){
		if (_subitem != null) {
			_subitem.css("visibility","hidden");	
		}
		_visible=false;
		_subitem= null;
		_img.css("border-style","solid");
	}
	
	function show(){
		_visible = true;
		_subitem.css("visibility","visible");
	}

	/**
	 * Events handler
	 */
	$(".selector li a.trigger").mouseover(function() {
		if (_img != null) {
			_img.css("border-style", "outset");
		}
	}).mouseout(function(){
		_hover = false;
    }).click(function(){
		if(!_visible){
			_subitem = $(this).parent().next();
			_trigger = $(this);
			_img = $(this).children("img");
			_img.css("border-style","inset");
			show();
		}else{
			_img.css("border-style","outset");
			hide();
		}
	}).blur(function () {
		if(!_hover) hide();
	});
	
	$('.subitem a').click(function() {
		hide();
	}).mouseover(function(){
		_hover = true;
    }).mouseout(function(){
		_hover = false;
    });
});