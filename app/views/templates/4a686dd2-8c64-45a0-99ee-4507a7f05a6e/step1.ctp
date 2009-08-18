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
  <div id="footer">
    <ul class="links">
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/privacy">Privacy</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/contactus">Contact</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/sitemap">Site Map</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/about/faq">FAQs</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/about/jobs">Jobs</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/copyright2" class="page">Copyright</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/rss" class="page">RSS</a></li>
      <li class="last"><a href="http://feeds.feedburner.com/GreenpeaceNews" class="rss" id="">&nbsp</a></li>
    </ul>
  </div>