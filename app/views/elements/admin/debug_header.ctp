<?php 
	$appeals = Appeal::getAppeals();
	pr($appeals);
?>
<div style="text-align:center;background:#FFF;margin-bottom:10px;border-bottom:1px solid #CCC;padding:5px;">
	<strong style="color:red;">Beta Test</strong> :
	<?php echo $html->link('Single Form Example', array('controller' => 'gifts', 'action' => 'add'))?> | 
	<?php echo $html->link('Multi Step Form Example', array('controller' => 'gifts', 'action' => 'add', '4a815eff-8a8c-40fa-9b65-72b6a7f05a6e'))?> | 
	<?php echo $html->link('Admin section', array('controller' => 'auth', 'action' => 'login', 'admin' => 1))?>
</div>
