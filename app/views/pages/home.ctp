  <div id="home" class="landing_page"><?php $tabindex = 1; ?>
	<?php echo $html->link('Eng', array('language' => 'eng'))?>
	<?php echo $html->link('Fre', array('language' => 'fre'))?>
    <h2>
      <?php echo __("White Rabbit - Easy Donating to Greenpeace")."\n"; ?>
<?php echo __('Give us some money and we will make the world a better place!')?>
      <?php echo $html->link(__("Get Involved!",true)." »","/register",array('class'=>'major'))."\n"; ?>
    </h2>
</div>

<h2>Choose A Country!</h2>
<?php
$countries = array(
	'4a8a76af-bd4c-4603-8c83-36e8a7f05a6e' => 'Belgium (1 Step Form)',
	'4a8a734a-9154-436e-9157-2da4a7f05a6e' => 'France (1 Step Form)',
	'4a8a76be-27b8-4da6-b22d-2da4a7f05a6e' => 'India (1 Step Form)',
	'4a8a766c-9588-44b0-b952-3714a7f05a6e' => 'Lebanon (1 Step Form)',
	'4a8a6ff2-83cc-4d63-b0dd-2dc8a7f05a6e' => 'Med (1 Step Form)',
	'4a6458a6-6ea0-4080-ad53-4a89a7f05a6e' => 'Other (GPI, 2 StepForm)'
);
?>
<ul>
<?php foreach ($countries as $id => $name) : ?>
	<li>
		<?php echo $html->link($name, array('controller' => 'gifts', 'action' => 'add', 'office_id' => $id))?>
	</li>
<?php endforeach ?>
</ul>
