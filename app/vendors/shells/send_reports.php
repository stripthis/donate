<?php
App::import('Core', 'Controller');
class SendReportsShell extends Shell {
	var $uses = array('Report', 'ReportsUser', 'Transaction', 'Gift');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$this->out('Calculating reports ..');

		// @todo: add frequency support
		$reports = $this->Report->find('all');
		if (empty($reports)) {
			$this->out('Found 0 reports. Exiting.');
			exit(1);
		}

		foreach ($reports as $report) {
			$this->out('Processing report "' . $report['Report']['title'] . '" ..');

			$users = $this->ReportsUser->find('all', array(
				'conditions' => array(
					'ReportsUser.report_id' => $report['Report']['id']
				),
				'contain' => array('User'),
				'order' => array('ReportsUser.created' => 'asc')
			));

			$this->out('Found ' . count($users) . ' user(s) that need a report');
			if (empty($users)) {
				continue;
			}

			$name = ucfirst($report['Report']['frequency']) . ' Report "' . $report['Report']['title'] . '"';
			foreach ($users as $user) {
				$officeId = $user['User']['office_id'];
				$query = $report['Report']['query'];
				$query = r('%condition', 'AND Gift.office_id = "' . $officeId . '"', $query);
				$results = $this->Transaction->query($query);

				$content = $this->parseTemplate($report['Report']['view'], $results);

				$options = array(
					'mail' => array(
						'to' => $user['User']['login'],
						'subject' => $name
					),
					'vars' => compact('content')
				);

				if (!Common::isDevelopment()) {
					Mailer::deliver('report', $options);
					$this->out('Sent ' . $name . ' to ' . $user['User']['login']);
				}
			}
		}
	}
/**
 * undocumented function
 *
 * @param string $template 
 * @param string $results 
 * @return void
 * @access public
 */
	function parseTemplate($template, $results) {
		$path = VIEWS . 'reports' . DS . 'templates' . DS . $template . '.ctp';
		ob_start();
		ob_implicit_flush(0);
		include($path);
		$content = ob_get_clean();
		return $content;
	}
}
?>