<?php
/**
 * Default Settings Controller
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 *
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Greenpeace International
 * @license     GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php
 */
class SettingsController extends AppController {
	/**
	 * Edit (admin)
	 * @param string $id leader.id
	 * @return void
	 * @access public
	 */
	function admin_edit($id = null) {
		$settings = $this->Setting->find('first');
		Assert::notEmpty($settings, '404');

		if ($this->isGet()) {
			return $this->data = $settings;
		}

		$this->Setting->set($this->data);
		if (!$this->Setting->save()) {
			return $this->Message->add(__('The settings could not be updated.', true), 'error');
		}
		$this->Message->add(__('The settings were saved', true), 'ok');
	}
}
?>