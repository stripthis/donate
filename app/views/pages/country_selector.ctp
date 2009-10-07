	<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
		<div id="content">
<?php echo $this->element('../templates/default/elements/title'); ?>
<?php echo $this->element('../templates/default/elements/teasers/mission'); ?>
<?php echo $this->element('../templates/default/elements/countries'); ?>
		<div class='decorator half' id='earth'> &nbsp;
			<?php //echo $html->image('templates/default/activist.jpeg'); ?>
		</div>
<?php echo $this->element('../templates/default/elements/teasers/legacy'); ?>
		<div class="clear"></div>
<?php echo $this->element('admin/debug/appeals_list', array('appeals'=> $appeals)); ?>
		</div>
	</div>
<?php echo $this->element('../templates/default/elements/footer'); ?>
