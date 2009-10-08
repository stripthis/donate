	<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
		<div id="content">
<?php echo $this->element('../templates/default/elements/teasers/title1'); ?>
<?php echo $this->element('../templates/default/elements/teasers/mission1'); ?>
<?php echo $this->element('../templates/default/elements/countries'); ?>
<?php echo $this->element('../templates/default/elements/decorators/earth'); ?>
<?php echo $this->element('../templates/default/elements/legacy'); ?>
		<div class="clear"></div>
<?php echo $this->element('admin/debug/appeals_list', array('appeals'=> $appeals)); ?>
		</div>
	</div>
<?php echo $this->element('../templates/default/elements/footer'); ?>
