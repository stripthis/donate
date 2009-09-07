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
			'Guests' => array(

			)
			, 'appeal_sub' => array(
				'My Office' => array(
					'/admin/appeals/office'
					, '#/^\/admin\/appeals\/office.*$/iU'
				)
				, 'All Appeals' => array(
					'/admin/appeals'
					, '#/^\/admin\/appeals.*$/iU'
				)
			)
			, 'gift_sub' => array(
				'All' => array(
					'/admin/gifts'
					, '#/^\/admin\/gifts.*$/iU'
				)
				, 'Recurring' => array(
					'/admin/gifts/recurring'
					, '#/^\/admin\/gifts\/recurring.*$/iU'
				)
				, 'Starred' => array(
					'/admin/gifts/starred'
					, '#/^\/admin\/gifts\/starred.*$/iU'
				)
			)
			, 'transaction_sub' => array(
				'All' => array(
					'/admin/transactions'
					, '#/^\/admin\/transactions.*$/iU'
				)
				, 'Pending' => array(
					'/admin/transactions/pending'
					, '#/^\/admin\/transactions\/pending.*$/iU'
				)
				, 'Hard Errors' => array(
					'/admin/transactions/harderrors'
					, '#/^\/admin\/gifts\/transactions\/harderrors.*$/iU'
				)
				, 'Soft Errors' => array(
					'/admin/transactions/harderrors'
					, '#/^\/admin\/gifts\/transactions\/softerrors.*$/iU'
				)
				, 'Retried' => array(
					'/admin/transactions/harderrors'
					, '#/^\/admin\/gifts\/transactions\/retried.*$/iU'
				)
				, 'Successful' => array(
					'/admin/transactions/harderrors'
					, '#/^\/admin\/gifts\/transactions\/successful.*$/iU'
				)
			)
			, 'user_sub' => array(
				'My Colleagues' => array(
					'/admin/users/index/office'
					, '#/^\/admin\/users\/office.*$/iU'
				)
				, 'All Colleagues' => array(
					'/admin/users/index/all'
					, '#/^\/admin\/users\/all.*$/iU'
				)
			)
			, 'supporter_sub' => array(
				'All' => array(
					'/admin/supporters'
					, '#/^\/admin\/supporters.*$/iU'
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
			, 'Admin' => array(
				'Home' => array(
					'/admin/home'
					, '#/^\/admin\/statistics.*$/iU'
				),
				'Appeals' => array(
					'/admin/appeals/'
					, '#/^\/admin\/appeals.*$/iU'
				)
				, 'Gifts' => array(
					'/admin/gifts'
					, '#/\/admin\/gifts.*/iU'
				)
				, 'Transactions' => array(
					'/admin/transactions'
					, '#/\/admin\/transactions.*/iU'
				)
				, 'Supporters' => array(
					'/admin/supporters'
					, '#/\/admin\/supporters.*/iU'
				)
				, 'Offices' => array(
					'/admin/offices'
					, '#/\/admin\/offices.*/iU'
					, 'role' => 'Root'
				)
				, 'Users' => array(
					'/admin/users'
					, '#/\/admin\/users.*/iU'
					, 'role' => 'Root'
				)
				, 'Bugs' => array(
					'/admin/bugs'
					, '#/\/admin\/bugs.*/iU'
					, 'role' => 'Root'
				)
				, 'Office Config' => array(
					'/admin/offices/edit' . $Session->read('Office.id')
					, '#/\/admin\/offices.*/iU'
					, 'role' => 'SuperAdmin'
				)
			)
		);

		if (!empty($navGroup) && isset($navigations[$navGroup])) {
			return $navigations[$navGroup];
		}

		$navigation = $navigations['Guests'];
		if (class_exists('User') && !User::isGuest()) {
			$navigation = $navigations['Admin'];
		}
		return $navigation;
	}
}
?>