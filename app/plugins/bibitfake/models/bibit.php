<?php
class Bibit extends BibitfakeAppModel {
	var $useTable = false;
/**
 * undocumented function
 *
 * @param string $options 
 * @return void
 * @access public
 */
	function process($options = array()) {
		$defaults = array(
			'type' => 'redirect',
			'tId' => false
		);
		$options = am($defaults, $options);

		if ($options['type'] == 'redirect') {
			$myXml = $this->inquiry($options['tId']);

			App::import('Core', 'Xml');
			$xml = new XML($myXml);
			$data = $xml->toArray();

			return array(
				'order_id' => $data['PaymentService']['Reply']['OrderStatus']['orderCode'],
				'url' => $data['PaymentService']['Reply']['OrderStatus']['reference']['value']
			);
		}
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function inquiry($tId) {
		$microtime = array_sum(explode(' ', microtime()));
		$referenceId = substr(0, 10, sha1($microtime));
		$orderId = substr(0, 10, sha1($microtime + 1));

		$base = Router::url('/bibit/redirect/', true);
		$successUrl = Router::url('/gifts/thanks');
		$failUrl = $base . 'failure';
		$pendingUrl = $base . 'pending';

		$redirectUrlInquiry = <<<HTML
		https://secure.wp3.rbsworldpay.com/jsp/shopper/SelectPaymentMethod.jsp?orderKey=GREENPEACE^T0211010&
country=GB&language=en&bodyAttr=bgcolor%3D%22black%22&fontAttr=face%3D%22arial%22+color%3D%22white%22&successURL={$successUrl}&failureURL={$failUrl}&pendingURL={$pendingUrl}&preferredPaymentMethod=VISA-SSL
HTML;

		$redirectUrl = Router::url('/bibit/redirect/choose/' . $tId);

		$xml = <<<XML
			<?xml version="1.0"?>
			<!DOCTYPE paymentService PUBLIC "-//WorldPay/DTD RBS WorldPay PaymentService v1//EN" "http://dtd.wp3.rbsworldpay.compaymentService_v1.dtd">
			<paymentService merchantCode="GREENPEACE" version="1.4">
				<reply>
					<orderStatus orderCode="{$orderId}">
						<reference id="{$referenceId}">{$redirectUrl}</reference>
					</orderStatus>
				</reply>
			</paymentService>
XML;
		return $xml;
	}
}
?>