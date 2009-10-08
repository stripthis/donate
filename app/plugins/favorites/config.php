<?php
App::import('Model', 'Favorites.Favorite');
$Session = Common::getComponent('Session');
$officeId = $Session->read('Office.id');
$config = array(
	'Favorites' => array(
		'subject' => 'starred item',
		'verb' => 'star',
		'adjective' => 'starred',
		'models' => array(
			'Gift' => 'name',
			'Transaction' => 'serial',
			'User' => 'login',
			'Comment' => 'increment'
		),
		'loadConditions' => array(
			// beware here; always provide a backup condition for models unrelated to your load conditions
			'or' => array(
				'Gift.office_id' => $officeId,
				'Gift.id IS NULL'
			)
		)
	)
);
?>