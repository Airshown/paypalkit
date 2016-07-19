# PaypalMiniKit Guide

Guide pour utiliser notre MiniKit pour l'API de Paypal.

## Première étape : Inclure les sources dans votre Projet

Incluez le chargeur automatique fourni avec le Kit.

```sh
require_once __DIR__ . '/path/to/PaypalMiniKit/autoload.php';
```

## Deuxième étape : Connexion à l'API

Dans le fichier **config.xml**, indiquer les informations de votre compte API Paypal.

- **clientid** : correspond à l'ID client donné par Paypal
- **secretkey** : correspond à la clé secrète donnée par par Paypal
- **domainname** : correspond au serveur que vous allez requêter ( pour le développement : https://api.sandbox.paypal.com)
- **succesurl** : correspond à l'url de succès lors d'un paiement sur l'API Paypal
- **cancelurl** : correspond à l'url d'annulement de la transaction sur l'API Paypal

Ces informations seront utilisées par le MiniKit pour requêter l'API.

## Troisième étape : Utiliser notre MiniKit

Vous pouvez regarder l'exemple, où utiliser les fonctions suivantes :

**L'envoie des informations à Paypal**
```sh
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
// envoyer les informations de paiement à Paypal
$payment = PaypalMiniKit_Payment::payment($connexionPaypal, false, $data_transaction);

// utiliser l'url contenu dans cette variable pour rediriger l'utilisateur vers paypal
$payment['links'][1]['href'];

```

**Le fichier de succès**
```sh
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
```

**Le fichier d'annulation**
```sh
  Paiement annulé
```		
	
