/**
 * Drop down menu interactions
 *
 * Licensed under The General Public Licence v2 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	greenpeace international
 * @link		http://www.greenpeace.org
 * @license		GPL2 onwards - http://www.opensource.org/licenses/gpl-license.php
 *
 * Tabulated menu effects 
 * Hide and show submenu when pressing arrow down button
 * Acts like a dropdown list as far as the user interactions goes
 */
$(function() {
  var _current = null;
  var _visible = false;
  var _img = null;
  
  /***
   * Hide / show
   */
  function hide(){
	if (_current != null) {
  		_current.css("visibility","hidden");
	}
  	_visible=false;
  	_current= null;
  }
  
  function show(){
    _visible = true;
    _current.css("visibility","visible");
  }
  
  /**
   * Events handler
   */
  $(".selector li a.trigger").mouseover(function() {
	if (_img != null) {
	 	_img.css("border-style", "outset");
	}
  });
  
  $(".selector li a.trigger").click(function(){
    if(!_visible){
      _current = $(this).parent().next();
      _img = $(this).children("img");
      _img.css("border-style","inset");
      show();
    }else{
      _img.css("border-style","outset");
      hide();
    }
  });
  
	$('.subitem a').click(function() {
	    if(_current!=null && _visible){
	      _img.css("border-style","solid");
	      hide();
	    }
	});
  $(".selector ul.subitem a").click(function(){
    _img.css("border-style","solid");
    hide();
  });

  $(".selector ul.subitem").mouseout(function(){
    _hover = false;
  });
});