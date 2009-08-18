<?php
/**
 * "One Step" Donation page (cf. redirect model)
 * 
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   GREENPEACE INTERNATIONAL (c) 2009
 * @link        http://www.greenpeace.org/international/supportus
 */
  $this->pageTitle = "Support Us | Greenpeace International";
  $titleOptions = '';
  
  $cookie = Common::getComponent('Cookie');
  
  if (!empty($cData)) {
    $cData = $cData['Gift'];
  }
  $required = '<strong class="required">*</strong>';
  $checked = 'checked="checked"';
?>
  <div id="content_wrapper">
    <div id="banner">
      <h1><?php echo $this->pageTitle; ?></h1>
      <a href="http://www.greenpeace.org" alt="Greenpeace" class="greenpeace"><span>Greenpeace</span></a>
      <a href="http://localdonate.com" alt="Greenpeace" class="donate"><span>Support Us</span></a>
    </div>
    <div id="content">
      <h1>Support Greenpeace International</h1>
      <p class="mission">
        Greenpeace relies on donations from generous individuals to carry out our work.<br/>
        In order to remain independent, we do not accept funding from governments, corporations or political parties.
        <strong>We can't do it without your help.</strong>
      </p>
      <p class="message information">Hint: <strong class="required">*</strong> indicates a required field</p>
<?php foreach ($flashMessages as $message): ?>
      <p class="message <?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></p>
<?php endforeach; ?>
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
<?php 
			echo $this->element('../templates/default/gift', array(
				"required" => $required, 
				"checked" => $checked
			));
?>
      <div class="form_decoration half left" id="activist">
        <p>
          &#x201c; Greenpeace exists because this fragile Earth deserves a voice. 
          It needs solutions. It needs change. It needs action. &#x201d;
        </p>
      </div>
      <div class="spacer"></div>
<?php 
			echo $this->element('../templates/default/contact', array(
				"required" => $required, 
				"checked" => $checked
			));
?>
<?php 
			echo $this->element('../templates/default/payment', array(
				"required" => $required, 
				"checked" => $checked
			));
?>
      <?php echo $form->end('Donate'); ?>
    </div>
  </div>
  <div class="clear"></div>
<?php echo $this->element('footer') ?>