<?php
class UploaderComponent extends Object {
	var $uploadPath;
	var $filedata = array();
	var $filename;
/**
 * undocumented function
 *
 * @param string $controller
 * @return void
 * @access public
 */
	function startup(&$controller) {
		 $this->uploadPath = 'files' . DS;
	}
/**
 * undocumented function
 *
 * @param string $filedata
 * @param string $uploadPath
 * @param string $filename
 * @return void
 * @access public
 */
	function upload($filedata = null, $uploadPath = null, $mimeRules = array(), $isImage = true) {
		if ($filedata != null) {
			$this->filedata = $filedata;
		}

		if ($uploadPath != null) {
			$this->uploadPath = $uploadPath;
		}

		if (!empty($mimeRules)) {
			$passesMime = false;
			foreach ($mimeRules as $rule) {
				if ($this->filedata['type'] == $rule) {
					$passesMime = true;
					break;
				}
			}
		}

		if (!$passesMime) {
			return 'mime-error';
		}

		if (!$this->validate()) {
			return false;
		}

		App::import('Core', 'Sanitize');
		$this->filedata['name'] = Sanitize::paranoid($this->filedata['name'], array('.', '-', '_'));
		$this->filename = $this->makeUniqueName() . '_' . $this->filedata['name'];
		$destFile = $this->uploadPath . $this->filename;

		if ($isImage === true && method_exists($this, 'defaultImageHandler')) {
			$this->defaultImageHandler();
		}

		if (move_uploaded_file($this->filedata['tmp_name'], $destFile)) {
			return $destFile;
		}

		return false;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function validate() {
		if ($this->filedata['error'] != UPLOAD_ERR_OK) {
			return false;
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function makeUniqueName() {
		return substr(md5(microtime()), 0, 5);
	}
}