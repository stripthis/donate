		<div id="country_selector">
			<ul class="selector">
        <li>
          <div class="item">
			<?php $Session = Common::getComponent('Session'); ?>
            <a href="/admin/home"><?php echo $Session->read('Office.name'); ?></a>
            <a href="<?php echo Router::url(); ?>#" class="trigger">
              <?php echo $html->image('layout/tab_arrow_down.png'); ?>
            </a>
          </div>
          <ul style="visibility:hidden;" class="subitem">
			<?php
			$parent = $Session->read('Office.ParentOffice');
			if (!empty($parent['id'])) {
				$parent = AppModel::normalize('Office', $parent);
				echo '<li>' . $html->link('Back to ' . $parent['Office']['name'], array(
					'controller' => 'offices', 'action' => 'activate', $parent['Office']['id']
				)) . '</li>';
			}
			$subOffices = $Session->read('Office.SubOffice');
			if (!empty($subOffices)) {
				foreach ($subOffices as $office) {
					$office = AppModel::normalize('Office', $office);
					echo '<li>' . $html->link('Activate ' . $office['Office']['name'], array(
						'controller' => 'offices', 'action' => 'activate', $office['Office']['id']
					)) . '</li>';
				}
			}
			?>
          </ul>
        </li>
	  </div>