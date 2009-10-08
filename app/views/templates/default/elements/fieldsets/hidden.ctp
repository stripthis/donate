		<?php //echo $form->create('Gift', array('url' => $this->here . '/2'))."\n"; ?>
		<?php echo $form->input( 'Gift.id', array('type' => 'hidden'))."\n"; ?>
		<?php echo $form->input( 'Gift.type', array('type' => 'hidden', "value" => "donation"))."\n"; ?>
		<?php echo $form->input( 'Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>
