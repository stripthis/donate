		<div id="country_selector">
			<ul class="selector">
        <li>
          <div class="item">
            <a href="/admin/home">International</a>
            <a href="<?php echo Router::url(); ?>#" class="trigger">
              <?php echo $html->image('layout/tab_arrow_down.png'); ?>
            </a>
          </div>
          <ul style="visibility:hidden;" class="subitem">
            <li><a href="/admin/home">test</a></li>
            <li><a href="/admin/home">test1</a></li>
            <li><a href="/admin/home">test2</a></li>
          </ul>
        </li>
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
