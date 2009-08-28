<?php
if (empty($offices)) {
	return;
}

$depth = isset($depth) ? $depth : 1;
echo '<ul>';
foreach ($offices as $office) {
	echo '<li>';
	echo $office['Office']['name'];
	echo '</li>';
	echo $this->element('../offices/tree', array('offices' => $office['children'], 'depth' => $depth + 1));
}
echo '</ul>';
?>