<?php
class ReportFixture extends CakeTestFixture {
	var $name = 'Report';
	var $records = array(
		array(
			'id' => '4ab7d750-12ac-4b4d-968a-5e83a7f05a6e',
			'title' => 'Daily Pending Transactions',
			'filename' => 'pending_daily_YYYY_MM_DD',
			'query' => 'SELECT Transaction.*, Gift.* 
				FROM transactions Transaction 
				LEFT JOIN gifts Gift ON (Gift.id = Transaction.gift_id);',
			'view' => 'transactions_default'
		)
	);
}
?>