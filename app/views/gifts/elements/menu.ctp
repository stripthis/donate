<div class="menu_wrapper">
  <ul class="menu with_tabs">
	<li>
		<?php
		$selected = array('class' => 'selected');
		$options = $type == '' ? $selected : array();
		echo $html->link(__('All',true), array('action'=>'index', 'admin' => true), $options);
		?>
	</li>
    <li>
		<?php
		$selected = array('class' => 'selected');
		$options = $type == 'recurring' ? $selected : array();
		echo $html->link(__('Recurring',true), array('action'=>'index', 'recurring', 'admin' => true), $options);
		?>
	</li>
	<li>
		<?php
		$options = $type == 'onetime' ? $selected : array();
		echo $html->link(__('One Time',true), array('action'=>'index', 'onetime', 'admin' => true), $options);
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
