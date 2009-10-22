<div  id="userbadge">
	<?php //echo $common->gravatar(User::get('login'), '15')?>
	<?php echo __('Welcome back')?> <strong><?php echo User::get('name'); ?></strong> (<?php echo Inflector::humanize(User::get('Role.name')); ?>): 
	<a href="<?php echo Router::Url('/admin/users/preferences',true) ?>" class="iconic profile"><?php echo __('preferences',true);?></a>&nbsp; | 
	<a href="<?php echo Router::Url('/admin/auth/logout',true) ?>" class="logout"><?php echo __('logout',true);?></a>
</div>
