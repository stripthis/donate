<?php
class Template extends AppModel {
	var $actsAs = array(
		'Containable', 'Lookupable', 'SavedBy',
		'Sluggable' => array('label' => 'name')
	);

	var $hasMany = array(
		'TemplateStep' => array(
			'dependent' => true
		),
	);
/**
 * undocumented function
 *
 * @param string 
 * @param string 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'published_list':
				return $this->find('list', array(
					'conditions' => array(
						'published' => '1'
					)
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		if (isset($this->data[__CLASS__]['template_id'])) {
			$this->toCopy = $this->data[__CLASS__]['template_id'];
		}

		if (isset($this->data['step'])) {
			$this->steps = $this->data['step'];
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave($created) {
		$id = $this->id;
		$template = $this->find('first', array(
			'conditions' => compact('id'),
		));
		$slug = $template[__CLASS__]['slug'];

		$templateToCopy = false;
		if (isset($this->toCopy) && $this->toCopy !== false) {
			$templateToCopy = $this->find('first', array(
				'conditions' => array('id' => $this->toCopy),
			));
			$this->toCopy = false;
		}

		App::import('Core', 'Folder');
		$folder = new Folder(VIEWS . 'templates');
		$contents = $folder->read();

		$move = false;
		foreach ($contents[0] as $dir) {
			if (strpos($dir, $id) !== false) {
				$move = $dir;
				break;
			}
		}

		$this->path = VIEWS . 'templates' . DS . $slug . '_' . $id;
		if ($created) {
			mkdir($this->path, 0755);

			$imgPath = WWW_ROOT . 'img' . DS . 'templates' . DS . $slug . '_' . $id;
			mkdir($imgPath, 0755);

			// add thanks page automatically
			$filePath = $this->path . DS . 'thanks.ctp';
			$content = "<?php echo \$this->element('../templates/default/thanks'); ?>";
			file_put_contents($filePath, $content);

			$this->TemplateStep->create(array(
				'template_id' => $id,
				'is_thanks' => '1',
				'slug' => 'thanks',
				'num' => '0'
			));
			$this->TemplateStep->save();

			if (!empty($templateToCopy)) {
				$toCopyPath = VIEWS . 'templates' . DS . 
								$templateToCopy[__CLASS__]['slug'] . '_' . $templateToCopy[__CLASS__]['id'];

				$toCopyImgPath = WWW_ROOT . 'img' . DS . 'templates' . DS . 
								$templateToCopy[__CLASS__]['slug'] . '_' . $templateToCopy[__CLASS__]['id'];

				$folder = new Folder($toCopyPath);
				$folder->copy(array('to' => $this->path));
				$folder = new Folder($toCopyImgPath);
				$folder->copy(array('to' => $imgPath));

				$this->set(array(
					'id' => $id,
					'template_step_count' => $templateToCopy[__CLASS__]['template_step_count']
				));
				$this->save(null, false);
			}
		} else {
			if (!empty($move)) {
				$oldPath = VIEWS . 'templates' . DS . $move;
				$folder = new Folder($oldPath);
				$newPath = VIEWS . 'templates' . DS . $slug . '_' . $id;
				if ($newPath != $this->path) {
					$folder->move(array('to' => $newPath));
				}
			}
		}

		if (isset($this->steps)) {
			foreach ($this->steps as $num => $content) {
				if ($num != 'thanks') {
					$filePath = $this->path . DS . 'step' . $num . '.ctp';
					$stepRow = $this->TemplateStep->find('first', array(
						'conditions' => array(
							'template_id' => $id,
							'num' => $num
						)
					));

					if (empty($content)) {
						@unlink($filePath);
						if (!empty($stepRow)) {
							$this->TemplateStep->del($stepRow['TemplateStep']['id']);
						}
						continue;
					}

					// todo: support for thanks page
					file_put_contents($filePath, $content);
					if (empty($stepRow)) {
						$this->TemplateStep->create(array(
							'template_id' => $id,
							'slug' => 'step-' . $num,
							'num' => $num
						));
						$this->TemplateStep->save();
					}
					continue;
				}

				$filePath = $this->path . DS . 'thanks.ctp';
				if (!empty($content)) {
					file_put_contents($filePath, $content);
				}
			}
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function afterDelete() {
		App::import('Core', 'Folder');
		$folder = new Folder(VIEWS . 'templates');
		$contents = $folder->read();
		$toDelete = false;
		foreach ($contents[0] as $dir) {
			if (strpos($dir, $this->id) !== false) {
				$toDelete = $dir;
				break;
			}
		}

		if ($toDelete) {
			$oldPath = VIEWS . 'templates' . DS . $toDelete;
			$folder = new Folder($oldPath);
			$folder->delete();
		}
		return true;
	}
}
?>