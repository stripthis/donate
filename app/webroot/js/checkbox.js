/**
 * Checkbox styling - Jquery Checkbox v.1.3.0b1
 * @credit http://widowmaker.kiev.ua/checkbox/
 */	
$(document).ready(function() {
  // ":not([safari])" is desirable but not necessary selector
  $('.checkbox input:checkbox').checkbox();
  $('input:checkbox').checkbox();
  //$('input[safari]:checkbox').checkbox({cls:'jquery-safari-checkbox'});
  //$('input:radio').checkbox();
});