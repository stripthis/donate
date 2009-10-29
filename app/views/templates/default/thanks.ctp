<?php
$this->pageTitle = __('Thanks!', true);
?>
<div class="content_wrapper">
	<?php echo $this->element('../templates/default/elements/banner'); ?>
	<div id="content" id="thankyou">
		<?php echo $this->element('../templates/default/elements/teasers/title1'); ?>
	<ul>
		<li>
			<?php echo $html->link('Add Another Gift', array('controller' => 'gifts', 'action' => 'add'))?>
		</li>
		<li>
			<?php echo $html->link('Tell Your Friends!', array('controller' => 'tellfriends/tellfriends', 'action' => 'refer'))?>
		</li>
	</ul>
	</div>
</div>