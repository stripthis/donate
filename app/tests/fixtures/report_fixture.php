<?php
class ReportFixture extends CakeTestFixture {
	var $name = 'Report';
	var $records = array(
		array(
			'id' => '4ab7d750-12ac-4b4d-968a-5e83a7f05a6e',
			'title' => 'Daily Pending Transactions',
			'filename' => 'pending_daily_YYYY_MM_DD',
			'query' => 'SELECT * FROM transactions WHERE status = "pending";',
			'view' => 'transactions_default'
		)
	);
}
?>