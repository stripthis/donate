<?php
App::import(array('Model', 'AppModel'));
class UuidizeShell extends Shell {
	function main() {
		if (empty($this->args)) {
			return $this->err('Usage: ./cake uuidize <table>');
		}
		if ($this->args[0] == '?') {
			return $this->out('Usage: ./cake uuidize <table> [-force] [-reindex]');
		}
		$options = array(
			'force' => false,
			'reindex' => false,
		);
		foreach ($this->params as $key => $val) {
			foreach ($options as $name => $option) {
				if (isset($this->params[$name]) || isset($this->params['-'.$name]) || isset($this->params[$name{0}])) {
					$options[$name] = true;
				}
			}
		}

		foreach ($this->args as $table) {
			$name = Inflector::classify($table);
			$Model = new AppModel(array(
				'name' => $name,
				'table' => $table,
			));

			$records = $Model->find('all');

			foreach ($records as $record) {
				$Model->updateAll(
					array('id' => '"' . String::uuid() . '"'),
					array('id' => $record[$name]['id'])
				);
			}
		}
	}
}

?>