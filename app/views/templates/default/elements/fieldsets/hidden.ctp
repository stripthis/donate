<?php //echo $form->create('Gift', array('url' => $this->here . '/2'))."\n"; ?>
<?php echo $form->input('Gift.id', array('type' => 'hidden')); ?>
<?php echo $form->input('Gift.gift_type_id', array('type' => 'hidden', "value" => "donation")); ?>
<?php echo $form->input('Gift.appeal_id', array('type' => 'hidden')); ?>