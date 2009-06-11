<?php
if (is_array($response)):
	echo $javascript->object($response);
else:
	echo $response;
endif;
?>