<?php 
$searchOptions = array(
	'gifts' => __('Gifts',true),
	'transactions' => __('Transactions',true),
	'users' => __('Users',true),
	'appeals' => __('Appeals',true),
);
if (!User::allowed('Gifts', 'admin_view')) {
	unset($searchOptions['gifts']);
}
if (!User::allowed('Transactions', 'admin_view')) {
	unset($searchOptions['transactions']);
}
if (!User::allowed('Users', 'admin_view')) {
	unset($searchOptions['users']);
}
if (!User::allowed('Appeals', 'admin_view')) {
	unset($searchOptions['appeals']);
}
?>
<div class="search widget">
	<div class="widget_header">
	  <h3><a href="<?php echo Router::url(); ?>#" class="toggle open" id="toggle_search"><?php echo __('Search'); ?></a></h3>
  </div>
  <div class="widget_content">
   <div class="wrapper_toggle_search">
 	  <?php echo $form->create('search', array('url' => '/admin/search/go', 'id'=>'search'))."\n";?>
     <?php echo $form->input('Search.keyword', array('label' => __('Enter an id or a keyword',true)))."\n";?>
     <?php
         echo $form->input('Search.resource', array(
           'label' => '', 'options' => $searchOptions
         ))."\n";
     ?>
     <?php echo $form->end(__('search',true).' &#0187;')."\n";?>
   </div>
  </div>
</div>
