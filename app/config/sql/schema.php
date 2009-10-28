<?php 
/* SVN FILE: $Id$ */
/* App schema generated on: 2009-10-28 15:10:25 : 1256741545*/
class AppSchema extends CakeSchema {
	var $name = 'App';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $addresses = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'contact_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'line_1' => array('type' => 'string', 'null' => false, 'length' => 150),
		'line_2' => array('type' => 'string', 'null' => false, 'length' => 200),
		'zip' => array('type' => 'string', 'null' => false, 'length' => 20),
		'country_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'state_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'city_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'contactable' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'primary' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $appeals = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'parent_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'lang' => array('type' => 'string', 'null' => false, 'default' => 'eng', 'length' => 3),
		'appeal_step_count' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2),
		'name' => array('type' => 'string', 'null' => false),
		'slug' => array('type' => 'string', 'null' => false, 'length' => 100),
		'campaign_code' => array('type' => 'string', 'null' => false, 'length' => 100),
		'default' => array('type' => 'boolean', 'null' => false),
		'cost' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,2'),
		'targeted_income' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,2'),
		'targeted_signups' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'reviewed' => array('type' => 'boolean', 'null' => false),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'template_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $appeals_themes = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'appeal_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'theme_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $attachments = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'foreign_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'url' => array('type' => 'string', 'null' => false, 'length' => 500),
		'mimetype' => array('type' => 'string', 'null' => false, 'length' => 50),
		'size' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $auth_key_types = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 64),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $auth_keys = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'key' => 'index'),
		'auth_key_type_id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'index'),
		'key' => array('type' => 'string', 'null' => false, 'length' => 64, 'key' => 'unique'),
		'foreign_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'expires' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'unique_key' => array('column' => 'key', 'unique' => 1), 'one_key_per_type' => array('column' => array('user_id', 'auth_key_type_id'), 'unique' => 1), 'auth_key_type_id' => array('column' => 'auth_key_type_id', 'unique' => 0), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'auth_key_type_id_2' => array('column' => 'auth_key_type_id', 'unique' => 0))
	);
	var $cards = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'number' => array('type' => 'string', 'null' => false, 'length' => 25),
		'cardholder_name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'verification_code' => array('type' => 'string', 'null' => false, 'length' => 4),
		'expire_month' => array('type' => 'string', 'null' => false, 'length' => 2),
		'expire_year' => array('type' => 'string', 'null' => false, 'length' => 4),
		'card_type_idtype' => array('type' => 'string', 'null' => false, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array()
	);
	var $cities = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'country_id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'index'),
		'state_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'country_id' => array('column' => 'country_id', 'unique' => 0), 'state_id' => array('column' => 'state_id', 'unique' => 0))
	);
	var $contacts = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'fname' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'lname' => array('type' => 'string', 'null' => false),
		'salutation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 5),
		'title' => array('type' => 'string', 'null' => false, 'length' => 10),
		'email' => array('type' => 'string', 'null' => false),
		'dob' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'newsletter' => array('type' => 'boolean', 'null' => false),
		'contactable' => array('type' => 'boolean', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $countries = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $countries_offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'country_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $currencies = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50),
		'sign' => array('type' => 'string', 'null' => false, 'length' => 1),
		'iso_code' => array('type' => 'string', 'null' => false, 'length' => 3),
		'fractional_unit_name' => array('type' => 'string', 'null' => false, 'length' => 50),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $currencies_offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'currency_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $exports = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'nb_exported' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'model' => array('type' => 'string', 'null' => false, 'length' => 30),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $frequencies = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 20),
		'humanized' => array('type' => 'string', 'null' => false, 'length' => 20),
		'_order' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $frequencies_offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'frequency_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $gateway_processings = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'label' => array('type' => 'string', 'null' => false, 'length' => 20),
		'humanized' => array('type' => 'string', 'null' => false, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $gateways = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'uses_price' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'uses_rate' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $gateways_offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'gateway_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $gift_types = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 20),
		'humanized' => array('type' => 'string', 'null' => false, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $gift_types_offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'gift_type_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $gifts = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'continuous_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'new', 'length' => 10),
		'serial' => array('type' => 'string', 'null' => false, 'length' => 20),
		'due' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'contact_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'name' => array('type' => 'string', 'null' => false),
		'gift_type_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'amount' => array('type' => 'float', 'null' => false, 'length' => '10,2'),
		'description' => array('type' => 'text', 'null' => false),
		'frequency_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'currency_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'appeal_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'complete' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'archived_time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $i18n = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'locale' => array('type' => 'string', 'null' => false, 'length' => 6, 'key' => 'index'),
		'model' => array('type' => 'string', 'null' => false, 'key' => 'index'),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'field' => array('type' => 'string', 'null' => false, 'key' => 'index'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'locale' => array('column' => 'locale', 'unique' => 0), 'model' => array('column' => 'model', 'unique' => 0), 'row_id' => array('column' => 'foreign_key', 'unique' => 0), 'field' => array('column' => 'field', 'unique' => 0))
	);
	var $imports = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'serial' => array('type' => 'string', 'null' => false, 'length' => 20),
		'description' => array('type' => 'string', 'null' => false),
		'nb_requested' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'nb_imported' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $languages = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => false, 'length' => 3),
		'name' => array('type' => 'string', 'null' => false, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $languages_offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'language_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $offices = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'acronym' => array('type' => 'string', 'null' => false, 'length' => 3),
		'parent_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'country_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'state_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'city_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'amounts' => array('type' => 'string', 'null' => false, 'default' => '5,10,15'),
		'live' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'external_url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 300),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $phones = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'contact_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'address_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'phone' => array('type' => 'string', 'null' => false, 'length' => 30),
		'is_fax' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'contactable' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $posts = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $referrals = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'referred_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $reports = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 100),
		'filename' => array('type' => 'string', 'null' => false, 'length' => 100),
		'view' => array('type' => 'string', 'null' => false, 'length' => 100),
		'query' => array('type' => 'text', 'null' => false),
		'frequency' => array('type' => 'string', 'null' => false, 'length' => 15),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $reports_users = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'report_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'last_sent' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $roles = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 15),
		'permissions' => array('type' => 'string', 'null' => false, 'length' => 900),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'office_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'created_by' => array('type' => 'string', 'null' => false, 'length' => 36),
		'modified' => array('type' => 'datetime', 'null' => false),
		'modified_by' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $session_instances = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'key' => array('type' => 'string', 'null' => false, 'length' => 32, 'key' => 'unique'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index'),
		'data' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'key' => array('column' => 'key', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0))
	);
	var $settings = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'vote_cutoff' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $states = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'country_id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'country_id' => array('column' => 'country_id', 'unique' => 0))
	);
	var $template_step_visits = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'template_step_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'foreign_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'pageviews' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'ip' => array('type' => 'string', 'null' => false, 'length' => 20),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $template_steps = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'template_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'template_step_visit_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'num' => array('type' => 'integer', 'null' => false, 'length' => 2),
		'slug' => array('type' => 'string', 'null' => false, 'length' => 100),
		'is_thanks' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $templates = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => false),
		'slug' => array('type' => 'string', 'null' => false, 'length' => 100),
		'lang' => array('type' => 'string', 'null' => false, 'length' => 3),
		'template_step_count' => array('type' => 'integer', 'null' => false, 'length' => 2),
		'gateway_processing_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'created_by' => array('type' => 'string', 'null' => false, 'length' => 36),
		'modified' => array('type' => 'datetime', 'null' => false),
		'modified_by' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $themes = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'code' => array('type' => 'string', 'null' => false, 'length' => 4),
		'archived' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $transactions = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'parent_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'gateway_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'order_id' => array('type' => 'string', 'null' => false, 'length' => 30),
		'gift_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'import_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'serial' => array('type' => 'string', 'null' => false, 'length' => 20),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'new', 'length' => 100),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => false, 'length' => '10,2'),
		'currency_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'archived_time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $users = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'permissions' => array('type' => 'text', 'null' => false),
		'name' => array('type' => 'string', 'null' => false, 'length' => 150),
		'login' => array('type' => 'string', 'null' => false, 'length' => 50),
		'password' => array('type' => 'string', 'null' => false, 'length' => 50),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'lang' => array('type' => 'string', 'null' => false, 'default' => 'eng', 'length' => 5),
		'role_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'office_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'contact_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'referral_key' => array('type' => 'string', 'null' => false, 'length' => 10),
		'locale' => array('type' => 'string', 'null' => false, 'length' => 50),
		'has_donated' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tooltips' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'public_key' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'created_by' => array('type' => 'string', 'null' => false, 'length' => 36),
		'modified_by' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $widget_states = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'favorites' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'segments' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'filters' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'chat' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'news' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'shortcuts' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>