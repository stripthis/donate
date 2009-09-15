<?php
$type = isset($type) ? $type : 'Guest';
$Navigation = ClassRegistry::init('Navigation');
$navigation = $Navigation->get($type);

$div = isset($div) ? '<div class="' . $div . '">' : '';
$id = isset($id) ? 'id="' . $id . '"' : '';
$class = isset($class) ? 'class="' . $class . '"' : '';
$usePipe = isset($usePipe) ? $usePipe : false;
?>

<?php
if (!empty($div)) {
	echo $div;
}
?>
	<ul <?php echo $class ?> <?php echo $id ?>>
		<?php
		$currentLocation = substr($this->here, strlen($this->base));
		$total = count($navigation);
		$i = 0;

		foreach ($navigation as $name => $links) {
			$i++;
			$links = (array) $links;
			$options = array();
			if (isset($links['role'])) {
				if (!User::is($links['role'])) {
					continue;
				}
			}

			foreach ($links as $link) {
				if (
					$link == $currentLocation ||
					strpos($link, '#') === 0 && preg_match(substr($link, 1), $currentLocation)
				) {
					$options['class'] = 'selected';
					break;
				}
			}

			$idName = low(r(' ', '-', $name));
			echo '<li id="nav-' . $idName . '">' . $html->link($name, $links[0], $options, false, false) . '</li>';
			if ($usePipe && $i < $total) {
				echo '|';
			}
		}
		?>
		</ul>
<?php
if (!empty($div)) {
	echo '</div>';
	echo '<div class="clear"></div>';
}
?>