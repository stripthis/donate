<div class="subnav">
	<ul id="stats">
		<?php
		$map = array(
			'users' => 'Signup Rates',
			'gifts' => 'Number of Gifts, Amounts, etc.',
		);
		foreach ($map as $action => $title) {
			$class = $this->action == $action ? ' class="active"' : '';
			echo '<li' . $class . '>' . $html->link($title, compact('action')) . '</li>';
		}
		?>
	</ul>
</div>