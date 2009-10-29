<?php if (isset($appeals) && !empty($appeals)) : ?>
	<?php 
	$i = 0;
	$nb_appeal = count($appeals);
	?>
	<div class="country_selector half classic_box">
		<h3>Choose An Appeal! (admin debug)</h3>
		<ul class="half">
			<?php foreach ($appeals as $appeal) : $i++ ?>
				<?php if ($i > $nb_appeal / 2) : ?>
					</ul>
					<ul class="half">
				<?php endif;?>
				<li>
					<?php
					echo $html->link($appeal['Appeal']['name'], array(
						'controller' => 'gifts', 'action' => 'add', 'appeal' => $appeal['Appeal']['slug']
					));
					?>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif;?>
