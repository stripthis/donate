<?php 
/* SVN FILE: $Id$ */
/* TransactionsController Test cases generated on: 2009-07-21 17:07:41 : 1248189761*/
App::import('Controller', 'Transactions');

class TestTransactions extends TransactionsController {
	var $autoRender = false;
}

class TransactionsControllerTest extends CakeTestCase {
	var $Transactions = null;

	function setUp() {
		$this->sut = ClassRegistry::init('Transactions');
	}

	function tearDown() {
		unset($this->sut);
	}
}
?>