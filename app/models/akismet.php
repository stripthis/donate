<?php
/**
* This is a Model for CakePHP that allows you to use the excellent Akismet
* Api to fight spam in your application. 
* 
* See http://akismet.com/ for more information.
* 
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
* 
* Author: Felix Geisendörfer (thinkingphp.org / fg-webdesign.de)
**/

// If you don't have the WebModel class, go to http://cakeforge.org/snippet/detail.php?type=package&id=18
// and get it from there and putt it as web_model.php in your /app/ directory.
require_once(APP . 'web_model.php');

class Akismet extends WebModel  {
/**
* Use of the Akismet API requires an API key, which are currently 
* only being provided along with accounts to WordPress.com. However
* you can sign up there for free and just take the api key for your
* project. However, check the conditions on akismet.com
*
* @var string
*/
	var $apiKey = null;
/**
* Akismet likes to know the Application and Plugin name and version
* it's beeing called from. So let's be nice and give it to them.
*
* @var string
*/
	var $userAgent = 'CakePHP/1.1 | Akismet Web Model/1.0';
/**
* Verfies if a given Akismet API key is valid or not.
*
* @param string $key Only needed when $this->apiKey isn't set
* @param string $blog Url to your front page, get's detected automatically if ommited
* @return string
*/
	function verifyKey($key = null, $blog = null) {
		$vars = array();

		if (empty($blog))
			$vars['blog'] = FULL_BASE_URL;
		else 
			$vars['blog'] = $blog;

		if (empty($key))
			$vars['key'] = $this->apiKey;
		else 
			$vars['key'] = $key;

		$url = 'http://rest.akismet.com/1.1/verify-key';

		$headers = array();
		$headers[] = 'User-Agent: ' . $this->userAgent;

		return $this->httpPost($url, $vars, $headers);
	}
/**
* Checks weather a given $comment array is Spam or not.
* See http://akismet.com/development/api/#comment-check
* for information about the available paramters.
* 
* Imo the most important ones are these:
* - comment_author
* - comment_author_email
* - comment_author_url
* 
* Returns 'true' if the comment is Spam and 'false' if it isn't.
* It might also contains a short error message in some cases.
*
* @param array $comment
* @return string
*/
	function checkComment($comment) {
		return $this->__commentCall($comment, 'comment-check');
	}
/**
* Same parameters Akismet::checkComment(). The only difference is,
* that it is used to report a comment as spam so Akismet can learn 
* from it's mistakes.
* 
* I think Akismet returns '1' if submit was successfull and '0' if not.
*
* @param array $comment
* @return string
*/
	function submitSpam($comment) {
		return $this->__commentCall($comment, 'submit-spam');
	}
/**
* Same parameters Akismet::checkComment(). The only difference is,
* that it is used to report a false positive spam comment, so Akismet
* can learn from it's mistakes.
* 
* I think Akismet returns '1' if submit was successfull and '0' if not.
*
* @param array $comment
* @return string
*/
	function submitHam($comment) {
		return $this->__commentCall($comment, 'submit-ham');
	}
/**
* Used to perform comment related Api calls.
*
* @param array $comment
* @param string $type
* @return string
*/
	function __commentCall($comment, $type = 'comment-check') {
		if (empty($this->apiKey)) {
			// People will go crazy if they don't figure out they need an Api, so let's make there live
			// a little easier ; ).
			trigger_error('Akismet::checkComment() failed: No Akismet Api key has been set.', E_USER_WARNING);
			return false;
		}

		$vars = array();

		// We use the RequestHandlerComponent in order to figure out the Client-IP and Referrer
		//loadComponent('RequestHandler');

		if (!isset($comment['blog'])) {
			$vars['blog'] = FULL_BASE_URL;
		}

		if (!isset($comment['user_ip'])) {
			$vars['user_ip'] = RequestHandlerComponent::getClientIP();
		}

		if (!isset($comment['referrer '])) {
			$vars['referrer '] = RequestHandlerComponent::getReferrer();
		}

		if (!isset($comment['user_agent'])) {
			$vars['user_agent'] = env('HTTP_USER_AGENT');
		}

		$url = 'http://' . $this->apiKey . '.rest.akismet.com/1.1/' . $type;
		$vars = array_merge($vars, $comment);

		$headers = array();
		$headers[] = 'User-Agent: ' . $this->userAgent;

		return $this->httpPost($url, $vars, $headers);
	}
}
?>