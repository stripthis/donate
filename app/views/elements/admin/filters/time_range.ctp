<?php
//@todo date selection with calendar (in css/js)
//@todo optional day selection
?>
      <fieldset>
        <legend><a href="<?php echo Router::url();?>#" class="toggle open" id="filter_time_range"><?php __('Filter by date'); ?></a></legend>
        <div class="wrapper_filter_time_range">
	      <?php
		echo $form->input('start_date_year', array(
			'label' => __('Start Date', true) . ':',
			'type' => 'date',
			'value' => $params['start_date_year'],
			'dateFormat' => 'Y',
			'maxYear' => date('Y'),
			'empty' => '--'
		));
		echo $form->input('start_date_month', array(
			'label' => false,
			'type' => 'date',
			'value' => $params['start_date_month'],
			'dateFormat' => 'M',
			'empty' => '--'
		));
		echo $form->input('start_date_day', array(
			'label' => false,
			'type' => 'date',
			'value' => $params['start_date_day'],
			'dateFormat' => 'D',
			'empty' => '--'
		));

		echo $form->input('end_date_year', array(
			'label' => __('End Date',true).':',
			'type' => 'date',
			'value' => $params['end_date_year'],
			'dateFormat' => 'Y',
			'maxYear' => date('Y'),
			'empty' => '--'
		));
		echo $form->input('end_date_month', array(
			'label' => false,
			'type' => 'date',
			'value' => $params['end_date_month'],
			'dateFormat' => 'M',
			'empty' => '--'
		));
		echo $form->input('end_date_day', array(
			'label' => false,
			'type' => 'date',
			'value' => $params['end_date_day'],
			'dateFormat' => 'D',
			'empty' => '--'
		));
		?>
	</div>
	</fieldset>
