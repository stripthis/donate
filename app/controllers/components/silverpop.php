<?php
/**
 * Silverpop Component 
 * A component for Mass Mailing tools interactions
 * 
 * Copyright (c)	GREENPEACE INTERNATIONAL 2009
 * 
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Greenpeace International
 * @license		 GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php
 * @author		 rbertot@greenpeace.org
 *
 * @NOTE for speed purpose database references are hardcoded 
 *         (cf. leader UUID and Silverpop object names) 
 * @TODO XLM instead? with API secured login?
 */
App::import('Core', array('Xml', 'HttpSocket'));

class SilverpopComponent extends Object {
	var $name= 'Silverpop'; // aka Silverpoop
	var $description = "Greenpeace International mass mailing service";
	//var $controller; // current controller
	
	// webservice configuration
	var $config = array(
		"url" 		=> "http://links.mailing.greenpeace.org", // base url
		"optin" 	=> "/servlet/UserSignUp?",
		"optout" 	=> "/oo?"
	);
	
	// Request - default url parameters
	var $defaultRequest = array(
		"f" => "563239",				// registration form id
		"postMethod" => "HTML", // post method
		"m" => "0",							// other silverpop options
		"j" => "MAS2"
	);
	
	// default silverpop user structure
	var $default_user = array(
		"email" => "",
		"EMAIL" => "",
	  "Name" => "",
		"Country" => "",
		"State" => "",
		"City" => ""
	);
	
	// default silverpop vote structure
	var $default_vote = array(
		"Cisco" => "0",
		"Dell" => "0",
		"Fujitsu" => "0",
		"H_P" => "0", // 3 chars min for silverpoop, thus funky names..
		"IBM" => "0",
		"Intel" => "0",
		"Microsoft" => "0",
		"Nokia" => "0",
		"Sharp" => "0",
		"Sony" => "0",
		"Sun" => "0",
		"Toshiba" => "0"
		//"Panasonic" => "0",
		//"Google" => "0",
	);

/**
 * Startup
 * @param object $controller Controller using this component
 * @return boolean Proceed with component usage (true), or fail (false)
 */
	function startup(&$controller){
		$this->controller = &$controller; //@todo not Users controller dependent
	}

/**
 * Signup user (or update the details if already in there)
 * @param $user the user to sign up
 * @return $status:string{created,updated,error}
 */
	function UserSignUp($user=null){	
		$uri = $this->config["url"] . $this->config["optin"];
		$success = $this->__process($uri, $user);
		$res = "error";
		if(preg_match("/\bnow signed up/i",$success)){
			$res = "created";
		} elseif (preg_match("/\bhave been updated/i",$success)){
			$res = "updated";
		} else {
		  //pr($success);
		  //exit;
		}
		return $res;
	}

/**
 * Opt out user
 * @return bool
 */
	function UserOptOut($user=null){
		$uri = $this->config["url"] . $this->config["optout"];
		$success = $this->__process($uri, $user);
		return (preg_match("/\bhas been unsubscribed/i",$success));
	}

/**
 * Process a request and return silverpop answer if any
 * @param $url location of the request
 * @param $data details of the request
 * @access protected
 */
	function __process($uri, $user=null){
		if(!isset($user) || empty($user)) {
			$user = $this->__getUser();
		}
		$user = $this->__normalize($user);
		$data = array_merge($this->defaultRequest, $user); // prepare the request
		$socket = & new HttpSocket();											 // create the socket
		$response = $socket->post($uri, $data);						 // call the web service
		return $response;
	}
	
/**
 * Normalize data to be sent to silverpop
 * @param $user, cf. User::get()
 * @return $data array() normalized for silverpop
 */
	function __normalize($user){
		$data = am($this->default_user, $this->default_vote);
		if(isset($user["User"]["login"])) {
			$data["email"] = $data["EMAIL"] = $user["User"]["login"];
		}
	  if(isset($user["User"]["name"])) {
			$data["Name"] = $user["User"]["name"];
		}
		if(isset($user["Country"]["name"])) {
			$data["Country"] = $user["Country"]["name"];
		}
		if(isset($user["State"]["name"])) {
			$data["State"] = $user["State"]["name"];
		}
		if(isset($user["User"]["city"])) {
			$data["City"] = $user["User"]["city"];
		}
		if(isset($user["Vote"])) {
			foreach($user["Vote"] as $vote) {
				if(isset($vote["leader_id"]) && !empty($vote["leader_id"])) {
				  switch($vote["leader_id"]) { 
						case "49f31949-c60c-42b1-8707-da6c23c1de0a": $data["Microsoft"] = "1"; break;
						case "49f54c7f-734c-4924-b63b-41b323c1de0a": $data["Cisco"] = "1"; break;
						case "49f54c88-3484-4339-bb02-479723c1de0a": $data["IBM"] = "1"; break;
						case "49f54c90-7f7c-4c97-b35f-458723c1de0a": $data["Intel"] = "1"; break;
						case "49f54c9b-51c0-4743-af95-4e5323c1de0a": $data["Sun"] = "1"; break;
						case "49f54ca4-173c-4fa0-afd0-4b2123c1de0a": $data["H_P"] = "1"; break;
						case "49f54caf-1b90-42a3-ac80-445023c1de0a": $data["Dell"] = "1"; break;
						case "49f54cbb-3658-48ea-b6dc-49f323c1de0a": $data["Fujitsu"] = "1"; break;
						case "49f54cc3-3058-438c-8415-4a2223c1de0a": $data["Sony"] = "1"; break;
						case "49f54ccd-ca74-475d-828d-4a6d23c1de0a": $data["Toshiba"] = "1"; break;
						case "49f54cd7-6b78-4fcb-a1b9-430b23c1de0a": $data["Sharp"] = "1"; break;
						case "49f54ce9-e1e8-42a0-86c6-464723c1de0a": $data["Nokia"] = "1"; break;
						//case "": $data["Google"] = "1"; break;
						//case "": $data["Panasonic"] = "1"; break;
				  }
				}
			}
		}
		return $data;
	}

/**
 * @access private
 */
	function __getUser(){
		$me = User::get();
		// append the votes
		$me["Vote"] = $this->controller->User->Vote->find('all', array(
			'conditions' => array(
				'round_id' =>  ClassRegistry::init('Round')->current('id'),
				'user_id' => User::get('id')
			),
			'contain' => array("Leader.name")
		));
		return $me;
	}
}//_EOF
?>