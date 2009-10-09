<?php
//@todo date selection with calendar (in css/js)
//@todo optional "with day" selection
//@todo optional "with hours & min" selection
?>
			<fieldset>
        <legend><a href="<?php echo Router::url();?>#" class="toggle open" id="filter_time_range"><?php echo __('Filter by date', true); ?></a></legend>
        <div class="wrapper_filter_time_range">
        <div class="input date">
	      <?php
					echo $form->input('start_date_day', array(
						'label' => __('Start Date', true) . ':',
						'type' => 'date',
						'value' => $params['start_date_day'],
						'dateFormat' => 'D',
						'empty' => '--',
						'div' => false
					));
					echo $form->input('start_date_month', array(
						'type' => 'date',
						'value' => $params['start_date_month'],
						'dateFormat' => 'M',
						'empty' => '--',
						'label' => false,
						'div' => false
					)); 
					echo $form->input('start_date_year', array(
						'type' => 'date',
						'value' => $params['start_date_year'],
						'dateFormat' => 'Y',
						'maxYear' => date('Y'),
						'minYear' => date('Y'),
						'empty' => '--',
						'label' => false,
						'div' => false
					));
				   echo $form->input('start_date', array(
						'type' => 'hidden',
						'div' => false
					));
				?>
				</div>
				<div class="input date">
				<?php
						echo $form->input('end_date_day', array(
							'label' => __('End Date',true).':',
							'type' => 'date',
							'value' => $params['end_date_day'],
							'dateFormat' => 'D',
							'empty' => '--',
							'div' => false
						));
						echo $form->input('end_date_month', array(
							'type' => 'date',
							'value' => $params['end_date_month'],
							'dateFormat' => 'M',
							'empty' => '--',
							'div' => false,
							'label' => false
						));
						echo $form->input('end_date_year', array(
							'type' => 'date',
							'value' => $params['end_date_year'],
							'dateFormat' => 'Y',
							'maxYear' => date('Y') + 1,
							'minYear' => date('Y'),
							'empty' => '--',
							'label' => false,
							'div' => false
						));
					   echo $form->input('end_date', array(
							'type' => 'hidden',
							'div' => false
					));
					?>
				</div>
			</fieldset>
