<?php 
	//@todo depends on ACL
	$searchOptions = array(
		'gifts' => __('Gifts',true),
		'transactions' => __('Transactions',true),
		'users' => __('Users',true)
	);
?>
    <div class="search widget">
    	<div class="widget_header">
    	  <h3><a href="<?php echo Router::url(); ?>#" class="toggle open" id="trigger_search"><?php echo __('Search'); ?></a></h3>
      </div>
      <div class="widget_content">
	      <div class="toggle_wrapper" id="wrapper_trigger_search">
	    	  <?php echo $form->create('search',array('action' => 'search', 'id'=>'search'))."\n";?>
	        <?php echo $form->input('Search.keyword', array('label' => __('Enter an id or a keyword',true)))."\n";?>
	        <?php
	            echo $form->input('Search.ressource', array(
	              'label' => '', 'options' => $searchOptions
	            ))."\n";
	        ?>
	        <?php echo $form->end('Search!')."\n";?>
	      </div>
	      <div class="clear"></div>
      </div>
    </div>
