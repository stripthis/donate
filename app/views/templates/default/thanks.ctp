<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
	<div id="content">
<?php echo $this->element('../templates/default/elements/title'); ?>
	<ul>
		<li>
			<?php echo $html->link('Add Another Gift', array('controller' => 'gifts', 'action' => 'add'))?>
		</li>
		<li>
			<?php echo $html->link('Tell Your Friends!', array('controller' => 'tell_friends', 'action' => 'add'))?>
		</li>
	</ul>
	</div>
</div>