  <div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
     <div id="content">
<?php echo $this->element('../templates/default/elements/title'); ?>
<?php echo $this->element('../templates/default/elements/teasers/mission'); ?>
<?php echo $this->element('admin/debug/appeals_list', array('appeals'=> $appeals)); ?>
<?php echo $this->element('../templates/default/elements/countries'); ?>
<?php echo $this->element('../templates/default/elements/teasers/legacy'); ?>
		</div>
	</div>
<?php echo $this->element('../templates/default/elements/footer'); ?>