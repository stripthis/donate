<?php
class FavoritesAppController extends AppController {
	
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function init() {
		ClassRegistry::init('Favorite')->load(User::get('id'));
	}
}
?>
