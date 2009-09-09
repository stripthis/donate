<?php
if (!isset($items)) {
	return;
}

$delim = ';';
$result = array();
foreach ($items as $item) {
	$row = array();
	foreach ($item as $submodel => $data) {
		$row = am($row, $data);
	}
	$result[] = implode($delim, $row);
}
echo implode("\n", $result);
?>