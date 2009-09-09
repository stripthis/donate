<?php
	if(!isset($params['start_date'])) $params['start_date'] = false;
	if(!isset($params['end_date'])) $params['end_date'] = false;
	//@todo date selection with calendar (in css/js)
	//@todo optional day selection
?>
      <fieldset>
        <legend><a href="<?php echo Router::url();?>#" class="toggle open" id="filter_time_range"><?php __('Filter by date'); ?></a></legend>
        <div class="wrapper_filter_time_range">
	      <?php echo $form->input('start_date', array(
	        'label' => __('Start Date',true).':',
	        'type' => 'date',
	        'selected' => $params['start_date'],
	        'dateFormat' => 'MY',
	        'maxYear' => date('Y'),
			    'empty' => '--'
	      ));
	      ?>
	      <?php echo $form->input('end_date', array(
	        'label' => __('End Date',true).':',
	        'type' => 'date',
	        'selected' => $params['end_date'],
	        'dateFormat' => 'MY',
	        'maxYear' => date('Y'),
			    'empty' => '--'
	      ));
	      ?>
        </div>
      </fieldset>
