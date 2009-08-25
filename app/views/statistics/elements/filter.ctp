    <div class="filter">
      <?php echo $form->create('Statistics', array('url' => $this->here)); ?>
      <?php echo $form->input('startDate', array(
        'label' => 'Start Date:',
        'type' => 'date',
        'selected' => $startDate,
        'dateFormat' => 'MY',
        'maxYear' => date('Y')
      ));
      ?>
      <?php echo $form->input('endDate', array(
        'label' => 'End Date:',
        'type' => 'date',
        'selected' => $endDate,
        'dateFormat' => 'MY',
        'maxYear' => date('Y')
      ));
      ?>
    <?php echo $form->end('Filter'); ?>
    </div>
    <div class="clear"></div>