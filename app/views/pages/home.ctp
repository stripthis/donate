  <div id="home" class="landing_page"><?php $tabindex = 1; ?>
	<?php echo $html->link('Eng', array('language' => 'eng'))?>
	<?php echo $html->link('Fre', array('language' => 'fre'))?>
    <h2>
      <?php echo __("White Rabbit - Easy Donating to Greenpeace")."\n"; ?>
<?php echo __('Give us some money and we will make the world a better place!')?>
    </h2>
</div>

<h2>Choose An Appeal!</h2>
<ul>
<?php foreach ($appeals as $appeal) : ?>
	<li>
		<?php
		echo $html->link($appeal['Appeal']['name'], array(
			'controller' => 'gifts', 'action' => 'add', 'appeal_id' => $appeal['Appeal']['id']
		));
		?>
	</li>
<?php endforeach ?>
</ul>
