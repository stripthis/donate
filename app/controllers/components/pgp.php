<?php
class PgpComponent extends Object {
/**
 * undocumented function
 *
 * @param string $key 
 * @return void
 * @access public
 */
	function import($key) {
		$tmp = APP . 'tmp' . DS . 'pgpencrypt' . md5(uniqid(rand()));
		file_put_contents($tmp, $key);
		$cmd = 'gpg --import ' . $tmp;
		$a = `$cmd`;
		unlink($tmp);
		return true;
	}
/**
 * undocumented function
 *
 * @param string $options 
 * @return void
 * @access public
 */
	function encrypt($options) {
		$defaults = array(
			'msg' => 'Some message',
			'recipient' => 'user@example.com'
		);
		$options = am($defaults, $options);

		$tmp = APP . 'tmp' . DS . 'gpg' . DS . 'pgpencrypt' . md5(uniqid(rand()));
		$encrypted = $tmp . '.pgp';
		file_put_contents($tmp, $options['msg']);

		$use = 'gpg --trust-model always -r "' . $options['recipient'] . '" --out ' . $encrypted . ' --encrypt ' . $tmp;
		$a = `$use`;

		unlink($tmp);
		if (!file_exists($encrypted)) {
			return false;
		}

		$this->encrypted = $encrypted;
		return $encrypted;
	}
/**
 * undocumented function
 *
 * @param string $file 
 * @return void
 * @access public
 */
	function decrypt($file) {
		$tmp = APP . 'tmp' . DS . 'gpg' . DS . 'pgpencrypt' . md5(uniqid(rand()));
		$use = 'gpg --output ' . $tmp . ' --decrypt ' . $file;
		$a = `$use`;
		if (!file_exists($tmp)) {
			return false;
		}
		$out = file_get_contents($tmp);
		unlink($tmp);
		return $out;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function flush() {
		@unlink($this->encrypted);
	}
}
?>