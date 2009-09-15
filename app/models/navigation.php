<?php
/**
 * This Model is responsible for providing the navigation to the site depending on whether the user is logged in or not
 *
 * @package default
 * @access public
 */
class Navigation extends AppModel{
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $useTable = false;
/**
 * This function logs an activity of a given $activityType together with an array of $data related to it
 *
 * @param mixed $activityTypeId Either the numeric foreign key value for the activity_type or a string to look it up / create
 * @param array $data An array of data that will be serialized for later reference
 * @param $repeatWithin Either false or a timestamp in the past / array of conditions for this to qualify as a repeated activity
 * @return boolean True on success
 * @access public
 */
	function get($navGroup = null) {
		$Session = Common::getComponent('Session');

		$navigations = array(
		  // GUEST - NO MENU YET
			'Guests' => array(
			)
			// ADMIN MENU LEVEL 0 (main tabs)
			, 'Admin' => array(
				'Home' => array(
					'/admin/home'
					, '#/^\/admin(\/statistics|\/home).*$/iU'
				),
				'Appeals' => array(
					'/admin/appeals/index/all'
					, '#/^\/admin\/appeals.*$/iU'
				)
				, 'Gifts' => array(
					'/admin/gifts/index/all'
					, '#/\/admin(\/gifts|\/exports\/gifts).*/iU'
				)
				, 'Transactions' => array(
					'/admin/transactions/index/all'
					, '#/\/admin\/transactions.*/iU'
				)
				, 'Supporters' => array(
					'/admin/supporters'
					, '#/\/admin\/supporters.*/iU'
				)/*
				, 'Offices' => array(
					'/admin/offices'
					, '#/\/admin\/offices\/(index.*|manage_tree|add)?$/iU'
					, 'role' => 'root'
				)
				, 'Users' => array(
					'/admin/users/index/all'
					, '#/\/admin\/users.* /iU' <- added space here * / :)
					, 'role' => 'root'
				)
				, 'Bugs' => array(
					'/admin/bugs'
					, '#/\/admin\/bugs.* /iU' <- added space here * / :)
					, 'role' => 'root'
				)*/
				, __('Roles &amp; Permissions', true) => array(
					'/admin/roles'
					, '#/\/admin\/roles.*/iU'
					, 'role' => 'root'
				)
				, 'Config' => array(
					'/admin/offices/view/' . $Session->read('Office.id')
					, '#/\/admin\/(offices|users).*/iU'
					, 'role' => 'superadmin'
				)
				, 'Help' => array(
					'/admin/help'
					, '#/\/admin\/help.*/iU'
					, 'role' => 'admin'
				)
			)
			// ADMIN MENU LEVEL 1 (sub tabs)
			, 'appeal_sub' => array(
				'All' => array(
					'/admin/appeals/index/all'
					, '#/^\/admin\/appeals\/index\/all.*$/iU'
				)
				, 'My Office' => array(
					'/admin/appeals/index/office'
					, '#/^\/admin\/appeals\/index\/office.*$/iU'
				)
			)
			, 'gift_sub' => array(
				'All' => array(
					'/admin/gifts/index/all'
					, '#/^\/admin\/gifts\/index\/all.*$/iU'
				)
				, 'One Off' => array(
					'/admin/gifts/index/oneoff'
					, '#/^\/admin\/gifts\/oneoff.*$/iU'
				)
				, 'Recurring' => array(
					'/admin/gifts/index/recurring'
					, '#/^\/admin\/gifts\/recurring.*$/iU'
				)
				, 'Favorites' => array(
					'/admin/gifts/index/favorites'
					, '#/^\/admin\/gifts\/favorites.*$/iU'
				)
				, 'Archived' => array(
					'/admin/gifts/index/archived'
					, '#/^\/admin\/gifts\/archived.*$/iU'
				)
			)
			, 'transaction_sub' => array(
				'All' => array(
					'/admin/transactions/index/all'
					, '#/^\/admin\/transactions\/index\/all.*$/iU'
				)
				, 'Favorites' => array(
					'/admin/transactions/index/favorites'
					, '#/^\/admin\/gifts\/transactions\/index\/favorites.*$/iU'
				)/*
				, 'Pending' => array(
					'/admin/transactions/index/pending'
					, '#/^\/admin\/transactions\/index\/pending.*$/iU'
				)
				, 'Errors' => array(
					'/admin/transactions/index/errors'
					, '#/^\/admin\/gifts\/transactions\/index\/errors.*$/iU'
				)
				, 'Retried' => array(
					'/admin/transactions/index/retried'
					, '#/^\/admin\/gifts\/transactions\/index\/retried.*$/iU'
				)
				, 'Successful' => array(
					'/admin/transactions/index/successful'
					, '#/^\/admin\/gifts\/transactions\/index\/successful.*$/iU'
				)*/
				, 'Archived' => array(
					'/admin/transactions/index/archived'
					, '#/^\/admin\/gifts\/transactions\/index\/archived.*$/iU'
				)
				
			)
			, 'user_sub' => array(
				'All' => array(
					'/admin/users/index/all'
					, '#/^\/admin\/users\/index\/all.*$/iU'
				)
				, 'My Office Colleagues' => array(
					'/admin/users/index/colleagues'
					, '#/^\/admin\/users\/index\/colleagues.*$/iU'
				)
			)
			, 'supporter_sub' => array(
				'All' => array(
					'/admin/supporters'
					, '#/^\/admin\/supporters$/iU'
				),
				'Signups' => array(
					'/admin/supporters/index/signups'
					, '#/^\/admin\/supporters\/index\/signups.*$/iU'
				),
				'Donors' => array(
					'/admin/supporters/index/donors'
					, '#/^\/admin\/supporters\/index\/donors.*$/iU'
				)/*,
				'Major Donors' => array(
					'/admin/supporters/index/major_donors'
					, '#/^\/admin\/supporters\/index\/major_donors.*$/iU'
				),*/
				, 'Favorites' => array(
					'/admin/supporters/index/favorites'
					, '#/^\/admin\/supporters\/favorites.*$/iU'
				)
				, 'Archived' => array(
					'/admin/supporters/index/archived'
					, '#/^\/admin\/supporters\/archived.*$/iU'
				)
			)
			, 'user_preferences' => array(
				'Preferences' => array(
					'/admin/users/preferences'
					, '#/^\/admin\/users\/preferences.*$/iU'
				),
				'Edit Password' => array(
					'/admin/users/edit_password'
					, '#/^\/admin\/users\/edit_password.*$/iU'
				)
			)
			, 'admin_auth_sub' => array(
				'Login' => array(
					'/admin/auth/login'
					, '#/^\/admin\/(auth\/|)login.*$/iU'
				)
				, 'Lost Password' => array(
					'/admin/users/forgot_pw'
					, '#/^\/admin\/users\/forgot_pw.*$/iU'
				)
			)
			, 'admin_config_sub' => array(
				'Config' => array(
					'/admin/offices/view/' . $Session->read('Office.id')
					, '#/\/admin\/offices(\/edit|\/view)\/' . $Session->read('Office.id') . '.*/iU'
					, 'role' => 'superadmin'
				)
				, 'Users' => array(
					'/admin/users/index/' . $Session->read('Office.id')
					, '#/\/admin\/users\/index\/' . $Session->read('Office.id') . '.*/iU'
					, 'role' => 'superadmin'
				)
			)
			, 'admin_help_sub' => array(
				'Getting started' => array(
					'/admin/help'
					, '#/\/admin\/help(\/start)/'
					, 'role' => 'admin'
				)
				, 'Faq' => array(
					'/admin/help/faq'
					, '#/\/admin\/help\/faq\/.*/iU'
					, 'role' => 'admin'
				)
			)
		);

		if (!empty($navGroup) && isset($navigations[$navGroup])) {
			return $navigations[$navGroup];
		}

		$navigation = $navigations['Guests'];
		if (class_exists('User') && !User::is('guest')) {
			$navigation = $navigations['Admin'];
		}
		return $navigation;
	}
}
?>