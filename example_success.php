<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Exemple - Utilisation PaypalMiniKit</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
			<?php 
				require_once __DIR__ . '/paypalminikit/autoload.php';
				$connexionPaypal = new PaypalMiniKit_PaypalCurl();
				$payerId = $_GET['PayerID'];
				$payementId = $_GET['paymentId'];
				$paymentExecute = ['payer_id' => $payerId];
				$paymentExecuteUrl = 'https://api.sandbox.paypal.com/v1/payments/payment/' . $payementId . '/execute';
				$paymentExecuteResp = PaypalMiniKit_Payment::payment($connexionPaypal, $paymentExecuteUrl, $paymentExecute);
				
				if(array_key_exists ( 'name' , $paymentExecuteResp)){
					if($paymentExecuteResp['name'] == 'PAYMENT_ALREADY_DONE'){
						echo 'Paiement déjà réalisé <br>  <a href="https://developer.paypal.com/docs/api/#PAYMENT_ALREADY_DONE">Plus d\'informations</a>';
					}
				}
				if(array_key_exists ( 'state' , $paymentExecuteResp)){
					if($paymentExecuteResp['state'] == 'approved'){
						echo 'Paiement accepté';
					}
				}
			?>
		</div>
	</body>
</html>