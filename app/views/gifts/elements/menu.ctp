<div class="menu_wrapper">
  <ul class="menu with_tabs">
    <li>
		<?php
		$selected = array('class'=>'selected');
		$options = $type == 'monthly' ? $selected : array();
		echo $html->link(__('Monthly',true), array('action'=>'index', 'admin' => true), $options);
		?>
	</li>
	<li>
		<?php
		$options = $type == 'oneoff' ? $selected : array();
		echo $html->link(__('One-off',true), array('action'=>'index', 'oneoff', 'admin' => true), $options);
		?>
	</li>
	<li>
		<?php
		$options = $type == 'starred' ? $selected : array();
		echo $html->link(__('Starred',true), array('action'=>'index', 'starred', 'admin' => true), $options);
		?>
	</li>
  </ul>
</div>
<div class="clear"></div>
