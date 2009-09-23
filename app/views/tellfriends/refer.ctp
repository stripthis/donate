<div id="referDiv">
<?php echo $form->create('tellafriend', array('url' =>array('controller'=>'tellfriends', 'action'=>'refer')   )); ?>
<fieldset>
  <legend>Tell A Friend</legend>
  <ul>
    <li>
      <?php echo $form->input('Tellfriend.receiver', array('type' => 'text','label' => __('Friends\' Email (comma separated emails)',true).' *','class'=>'input text required','div'=>false))?>

    </li>
        <li>
      <?php echo $form->input('Tellfriend.sender', array('type' => 'text','label' => __('Your Email',true).' (Optional)','class'=>'input text required','div'=>false))?>

    </li>

    <li>
      <?php echo $form->input('Tellfriend.content', array('type' => 'textarea','label' => __('Your Message',true),'class'=>'input text required','div'=>false, 'value' => __('Hi, Your friend wants you to check out this website: www.greenpeace.org ', true)))?>
    </li>
     <li>
      <?php $recaptcha->display_form('echo'); ?>
    </li>
    
    <li>
	 <?php echo $form->end('Send Email'); ?>
    </li>
  </ul>
</fieldset>
</div>