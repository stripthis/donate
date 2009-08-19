  <div id="home" class="landing_page"><?php $tabindex = 1; ?>
	<?php echo $html->link('Eng', array('language' => 'eng'))?>
	<?php echo $html->link('Fre', array('language' => 'fre'))?>
    <h2>
      <?php echo __("White Rabbit - Easy Donating to Greenpeace")."\n"; ?>
<?php echo __('Give us some money and we will make the world a better place!')?>
      <?php echo $html->link(__("Get Involved!",true)." »","/register",array('class'=>'major'))."\n"; ?>
    </h2>
</div>