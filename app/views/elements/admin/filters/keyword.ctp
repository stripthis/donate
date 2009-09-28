      <fieldset>
        <legend><a href="<?php echo Router::url();?>#" class="toggle" id="gift_filter_options"><?php echo __('Filter by keyword', true);?></a></legend>
        <div class="wrapper_gift_filter_options">
          <?php echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $params['keyword'])); ?>  
          <?php echo $form->input('search_type', array('label' => 'Type:', 'selected' => $params['search_type'], 'options' => $typeOptions, 'class'=>'full')); ?>
        </div>
      </fieldset>
