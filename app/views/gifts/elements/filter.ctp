<?php
$typeOptions = array(
	'all' => 'All',
	'gift' => 'Gift Id',
	'person' => 'Person Name',
	'appeal' => 'Appeal Name'
);
?>
    <div class="filter">
      <?php echo $form->create('Gift', array('url' => '/admin/gifts/index/' . $type, 'type' => 'get')); ?>
      <fieldset>
        <legend><a href="<?php echo Router::url();?>#" class="toggle" id="gift_filter_options">Filter results</a></legend>
        <div class="wrapper_gift_filter_options">
          <?php echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $params['keyword'])); ?>  
          <?php echo $form->input('search_type', array('label' => 'Type:', 'selected' => $params['search_type'], 'options' => $typeOptions, 'class'=>'full')); ?>
        </div>
      </fieldset>
<?php echo $this->element('admin/filters/paging_limit'); ?>
      <?php echo $form->end('Filter');  ?>
    </div>
    <div class="clear"></div>
