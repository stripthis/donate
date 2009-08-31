<?php
ini_set('short_open_tag', 'Off');
?>
<?xml version="1.0" encoding="UTF-8" ?>
<?php
Configure::write('debug', 0);
echo $content_for_layout;
?>