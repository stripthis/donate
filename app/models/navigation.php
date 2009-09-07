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
					, 'rule' => 'Root'
				)
				, 'Users' => array(
					'/admin/users'
					, '#/\/admin\/users.*/iU'
					, 'rule' => 'Root'
				)
				, 'Bugs' => array(
					'/admin/bugs'
					, '#/\/admin\/bugs.*/iU'
					, 'rule' => 'Root'
				)
				, 'Office Config' => array(
					'/admin/offices/edit' . $Session->read('Office.id')
					, '#/\/admin\/offices.*/iU'
					, 'rule' => 'SuperAdmin'
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