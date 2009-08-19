		<div id="country_selector">
			
	  </div>
	  <?php
	/*
	<h3>Current Office</h3>
	$Session = Common::getComponent('Session');
	echo $Session->read('Office.name') . '<br />';

	$parent = $Session->read('Office.ParentOffice');

	if (!empty($parent['id'])) {
		$parent = AppModel::normalize('Office', $parent);
		echo $html->link('Back to ' . $parent['Office']['name'], array(
			'controller' => 'offices', 'action' => 'activate', $parent['Office']['id']
		));
	}
	<h3>Available Child Offices</h3>
	$subOffices = $Session->read('Office.SubOffice');
	if (empty($subOffices)) {
		echo '<p>' . __('The office has no suboffices.', true);
	} else {
		echo '<ul>';
		foreach ($subOffices as $office) {
			$office = AppModel::normalize('Office', $office);
			echo '<li>' . $html->link('Activate ' . $office['Office']['name'], array(
				'controller' => 'offices', 'action' => 'activate', $office['Office']['id']
			)) . '</li>';
		}
		echo '</ul>';
	}
	</div>
	*/
	?>
