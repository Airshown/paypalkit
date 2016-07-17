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
				/* 
					Attention : cet exemple ne gère pas les antiinjections, il ne peut pas être utilisé tel quel en production.
				*/
	
				if( !empty( $_POST ) ){
					// inclure le kit paypalminikit
					require_once __DIR__ . '/paypalminikit/autoload.php';
	
					// connexion à Paypal à l'aide de Curl et des inforamtions de connexions stockés dans le fichier : config.xml
					$connexionPaypal = new PaypalMiniKit_PaypalCurl();

					// le tableau des commandes de la transactions à payer
					$data_transaction = [
						'amount' => [
							'total' => $_POST['amount'],
							'currency' => $_POST['devise']
						],
						'description' => $_POST['description']
					];

					// ...
					$payment = PaypalMiniKit_Payment::payment($connexionPaypal, false, $data_transaction);
			?>
				<div class="jumbotron">
				<h2>Le paiement en cours</h2>
					<p>Paiement : <?php echo $payment['id']; ?></p>
					<p>Etat : <?php echo $payment['state']; ?></p>
					<p>Montant : <?php echo $_POST['amount']; ?></p>
					<p><b><a href="<?php echo $payment['links'][1]['href']; ?>">Valider le paiement</a></b></p>
				</div>
					
			<?php
				}else{
			?>
			<div class="jumbotron">
				<h2>Formulaire de test pour l'example</h2>
				<p> Ce formulaire permet de tester la fonction <i>PaypalMiniKit_Payment::payment</i> avec des input de différentes valeures.
				</p>
			</div>
			
			<form action="example.php" method="post">
				<div class="form-group">
					<label for="description">Description</label>
					<textarea id="description" class="form-control" name="description">Transaction pour l'achat d'un objet dans notre boutique.</textarea>
				</div>
				<div class="form-group">
					<label for="amount">Montant de la transaction</label>
					<input id="amount" class="form-control" type="number" step="0.01" name="amount" value="15.25">
				</div>
				<div class="form-group">
					<label for="amount">Devise</label>
						<select id="amount" name="devise" class="form-control">
							<option value="EUR">EUR</option>
							<option value="USD">USD</option>
						</select>
					</label>
				</div>
				<button type="submit" class="btn btn-primary">Valider le formulaire</button>
			</form>
			<?php	
				}
			?>
		</div>
	</body>
</html>