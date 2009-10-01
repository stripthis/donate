<?php
/**
 * Name: White Rabbit default template
 * Description: Once step donation page using direct model
 * Author: white rabbit team rocket!
 * Version: 0.1
 * 
 * @copyright   GREENPEACE INTERNATIONAL (c) 2009
 * Redistributions of files must retain the above copyright notice.
 */
  $this->pageTitle = "Support Us | Greenpeace International";
  $titleOptions = '';
  
  $cookie = Common::getComponent('Cookie');
  
  if (!empty($cData)) {
    $cData = $cData['Gift'];
  }
?>
  <div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
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
<?php echo $this->element('../templates/default/gift'); ?>
      <div class="form_decoration half left" id="activist">
        <p>
          &#x201c; Greenpeace exists because this fragile Earth deserves a voice. 
          It needs solutions. It needs change. It needs action. &#x201d;
        </p>
      </div>
      <div class="spacer"></div>
<?php echo $this->element('../templates/default/contact'); ?>
<?php	echo $this->element('../templates/default/payment'); ?>
     	<?php echo $form->submit('Donate', array('class' => 'donate-submit')); ?>
		<?php echo $form->end(); ?>
    </div>
  </div>
  <div class="clear"></div>
<?php echo $this->element('footer') ?>