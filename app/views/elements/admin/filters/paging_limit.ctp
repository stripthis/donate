<?php
	if (!isset($paginateOptions)) {
    $paginateOptions = array(10, 20, 40, 50, 75);
    $paginateOptions = array_combine($paginateOptions, $paginateOptions);
	}
?>
      <fieldset>
        <legend><a href="<?php echo Router::url();?>#" class="toggle close" id="display_settings">Pagination settings</a></legend>
        <div class="wrapper_display_settings">
        <?php 
          echo $form->input('my_limit', array(
                'label' => __('How many results per page?',true),
                'selected' => $params['my_limit'],
                'options' => $paginateOptions,
          )); 
        ?>
        <?php 
          echo $form->input('custom_limit', array(
                'label' => __('Prefer typing the number?',true),
                'value' => $params['custom_limit']
          )); 
        ?>
        </div>
      </fieldset>
