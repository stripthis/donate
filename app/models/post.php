<?php
class Post extends AppModel {
	var $hasMany = array(
		'Comment' => array(
			'foreignKey' => 'foreign_id'
		)
	);
/**
 * undocumented function
 *
 * @param string 
 * @param string 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'twitter':
				$cacheKey = 'posts_index_twitter';
				$posts = Cache::read($cacheKey);
				if (!$posts) {
					App::import('Core', 'Xml');
					$feed = Configure::read("App.rss.news");
					$rss = Set::reverse(new XML($feed['url']));
					$posts = array();
					if (isset($rss["Rss"]["Channel"]["Item"]) && !empty($rss["Rss"]["Channel"]["Item"])) {
						$posts = $rss["Rss"]["Channel"]["Item"];
						$posts['feed'] = $feed;
						Cache::write($cacheKey, $posts);
					}
				}
				return $posts;
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>