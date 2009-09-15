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
				__('Home', true) => array(
					'/admin/home'
					, '#/^\/admin(\/statistics|\/home).*$/iU'
				)
				, __('Appeals', true) => array(
					'/admin/appeals/index/all'
					, '#/^\/admin\/appeals.*$/iU'
				)
				, __('Gifts', true) => array(
					'/admin/gifts/index/all'
					, '#/\/admin(\/gifts|\/exports\/gifts).*/iU'
				)
				, __('Transactions', true) => array(
					'/admin/transactions/index/all'
					, '#/\/admin\/transactions.*/iU'
				)
				, __('Supporters', true) => array(
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
				, __('Config', true) => array(
					'/admin/offices/view/' . $Session->read('Office.id')
					, '#/\/admin\/(offices|users).*/iU'
					, 'role' => 'superadmin'
				)
				, __('Help', true) => array(
					'/admin/help'
					, '#/\/admin\/help.*/iU'
					, 'role' => 'admin'
				)
			)
			// ADMIN MENU LEVEL 1 (sub tabs)
			, 'appeal_sub' => array(
				__('All', true) => array(
					'/admin/appeals/index/all'
					, '#/^\/admin\/appeals\/index\/all.*$/iU'
				)
				, __('My Office', true) => array(
					'/admin/appeals/index/office'
					, '#/^\/admin\/appeals\/index\/office.*$/iU'
				)
			)
			, 'gift_sub' => array(
				__('All', true) => array(
					'/admin/gifts/index/all'
					, '#/^\/admin\/gifts\/index\/all.*$/iU'
				)
				, __('One Off', true) => array(
					'/admin/gifts/index/oneoff'
					, '#/^\/admin\/gifts\/oneoff.*$/iU'
				)
				, __('Recurring', true) => array(
					'/admin/gifts/index/recurring'
					, '#/^\/admin\/gifts\/recurring.*$/iU'
				)
				, __('Favorites', true) => array(
					'/admin/gifts/index/favorites'
					, '#/^\/admin\/gifts\/favorites.*$/iU'
				)
				, __('Archived', true) => array(
					'/admin/gifts/index/archived'
					, '#/^\/admin\/gifts\/archived.*$/iU'
				)
			)
			, 'transaction_sub' => array(
				__('All', true) => array(
					'/admin/transactions/index/all'
					, '#/^\/admin\/transactions\/index\/all.*$/iU'
				)
				, __('Favorites', true) => array(
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
				, __('Archived', true) => array(
					'/admin/transactions/index/archived'
					, '#/^\/admin\/gifts\/transactions\/index\/archived.*$/iU'
				)
				
			)
			, 'user_sub' => array(
				__('All', true) => array(
					'/admin/users/index/all'
					, '#/^\/admin\/users\/index\/all.*$/iU'
				)
				, __('My Office Colleagues', true) => array(
					'/admin/users/index/colleagues'
					, '#/^\/admin\/users\/index\/colleagues.*$/iU'
				)
			)
			, 'supporter_sub' => array(
				__('All', true) => array(
					'/admin/supporters'
					, '#/^\/admin\/supporters$/iU'
				)
				, __('Signups', true) => array(
					'/admin/supporters/index/signups'
					, '#/^\/admin\/supporters\/index\/signups.*$/iU'
				)
				, __('Donors', true) => array(
					'/admin/supporters/index/donors'
					, '#/^\/admin\/supporters\/index\/donors.*$/iU'
				)/*,
				'Major Donors' => array(
					'/admin/supporters/index/major_donors'
					, '#/^\/admin\/supporters\/index\/major_donors.*$/iU'
				),*/
				, __('Favorites', true) => array(
					'/admin/supporters/index/favorites'
					, '#/^\/admin\/supporters\/favorites.*$/iU'
				)
				, __('Archived', true) => array(
					'/admin/supporters/index/archived'
					, '#/^\/admin\/supporters\/archived.*$/iU'
				)
			)
			, 'user_preferences' => array(
				__('Preferences', true) => array(
					'/admin/users/preferences'
					, '#/^\/admin\/users\/preferences.*$/iU'
				)
				, __('Edit Password', true) => array(
					'/admin/users/edit_password'
					, '#/^\/admin\/users\/edit_password.*$/iU'
				)
			)
			, 'admin_auth_sub' => array(
				__('Login', true) => array(
					'/admin/auth/login'
					, '#/^\/admin\/(auth\/|)login.*$/iU'
				)
				, __('Lost Password', true) => array(
					'/admin/users/forgot_pw'
					, '#/^\/admin\/users\/forgot_pw.*$/iU'
				)
			)
			, 'admin_config_sub' => array(
				__('Config', true) => array(
					'/admin/offices/view/' . $Session->read('Office.id')
					, '#/\/admin\/offices(\/edit|\/view)\/' . $Session->read('Office.id') . '.*/iU'
					, 'role' => 'superadmin'
				)
				, __('Users', true) => array(
					'/admin/users/index/' . $Session->read('Office.id')
					, '#/\/admin\/users\/index\/' . $Session->read('Office.id') . '.*/iU'
					, 'role' => 'superadmin'
				)
			)
			, 'admin_help_sub' => array(
				__('Getting started', true) => array(
					'/admin/help'
					, '#/\/admin\/help(\/start)/'
					, 'role' => 'admin'
				)
				, __('Faq', true) => array(
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