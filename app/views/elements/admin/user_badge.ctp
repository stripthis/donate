    <div  id="userbadge">
    	Welcome back <strong><?php echo User::get('name'); ?></strong> (<?php echo User::get('login'); ?>) | 
    	<a href="<?php echo Router::Url("/admin/auth/logout",true) ?>" class="logout"><?php echo __("logout");?></a>
  	</div>
