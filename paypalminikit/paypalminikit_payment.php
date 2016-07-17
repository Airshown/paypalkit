<?php

class PaypalMiniKit_Payment {
	public static function payment($paypalkitObject, $url=false, $data){
		$config = PaypalMiniKit_ConfigReader::get();
		if(!array_key_exists ( 'payer_id' , $data )){
			$data = [$data];
			$payment = array(
				'intent' => 'sale',
				'payer' => array(
					'payment_method' => 'paypal'
				),
				'transactions' => $data,
				'redirect_urls' => array (
					'return_url' => $config['successurl'],
					'cancel_url' => $config['cancelurl']
				)
			);
			$data = json_encode($payment);
		
			if($url) {
				$array_request = [
				'url' => $url,
				'data' => $data	
				];
			} else {
				$array_request = [
					'url' => $config['domainname'].'/v1/payments/payment',
					'data' => $data	
				];
			}
			$paypalkit_object = $paypalkitObject;
			$response = $paypalkit_object->request($array_request);

			if( array_key_exists( 'links',$response ) )  {
				foreach ($response['links'] as $link) {
					if($link['rel'] == 'execute'){
						$paymentExecuteUrl = $link['href'];
						$paymentExecuteMethod = $link['method'];
					} else if($link['rel'] == 'approval_url'){
						$paymentApprovalUrl = $link['href'];
						$paymentApprovalMethod = $link['method'];
					}
				}
			}
			return $response;
		}else{	
			$data = json_encode($data);
			if($url) {
				$array_request = [
					'url' => $url,
					'data' => $data	
				];
			} else {
				$array_request = [
					'url' => 'https://api.sandbox.paypal.com/v1/payments/payment',
					'data' => $data	
				];
			}
			$paypalkit_object = $paypalkitObject;
			$response = $paypalkit_object->request($array_request);
			return $response;
		}
		

	}

	public static function getInfos($paypalkitObject, $url) {
		$paypalkit_object = $paypalkitObject;
		$array_request = [
			'url' => $url
		];
		$response = $paypalkit_object->request($array_request);
		return $response;
	}
}