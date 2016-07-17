<?php 

class PaypalMiniKit_PaypalCurl {

	// Token donné par l'api lors de l'authentification
	private $paypal_token;
	
	
	/*
		Constructeur
		String @domain_name : adresse url du serveur requété
	*/
	public function __construct(){
		
		// création du token
		$this->paypal_token = $this->generateAccessToken();
	}
	
	
	
	/*
		Fonction qui permet de générer le Token
	*/
	private function generateAccessToken(){
		$config = PaypalMiniKit_ConfigReader::get();
		/*
			url : url curlé
			headers : les headers HTTP (-H)
			user : identifiant de connexion 'client_id:secret_key' (-u)
			data : data posté, ici on demande de récupérer les informations de l'user (-d)
		*/

		$response = $this->request([
			'url' => $config['domainname'].'/v1/oauth2/token',
			'headers' => [
				'Accept' => 'application/json',
				'Accept-Language' => 'en_US'
			],
			'user' => $config['clientid'].':'.$config['secretkey'],
			'data' =>	'grant_type=client_credentials'
		]);
		return $response['access_token'];
	}
	
	/*
	Unique fonction publique à part le constructeur
	Permet de générer une requête (BUG pour le moment)
	(l'exemple - qui ne fonctionne pas - présent dans les paramètres sera enlevé pour faire des requetes GET)
	
	Array @data : ensemble des informations à indiquer
	String @url : url requété	
	*/
	
	/*
		Génération de la requête en cUrl, récupération de la réponse en objet
		Array @array_request : ensemble des paramètres de la requête
			- data (-d)
			- user (-u)
			- headers (-H)
			- url
	*/
	public function request($array_request ){
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $array_request['url']);

		//if post request
		if (array_key_exists ('data',$array_request)) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $array_request['data']);
		} else {
			curl_setopt($curl, CURLOPT_POST, false);
		}

		if (array_key_exists ( 'headers',$array_request)){
			curl_setopt($curl, CURLOPT_HTTPHEADER, $array_request['headers']);
		} else {
			curl_setopt($curl, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer '.$this->paypal_token,
			'Accept: application/json',
			'Content-Type: application/json'
			]);
		}

		if (array_key_exists ( 'user',$array_request)){
			curl_setopt($curl, CURLOPT_USERPWD, $array_request['user']);
		}
		 
		$response = curl_exec( $curl );
		
		if (empty($response)) {
		    var_dump(curl_error($curl));
		    curl_close($curl);
			exit();
		} else {
		    $info = curl_getinfo($curl);
		    curl_close($curl);
			if($info['http_code'] != 200 && $info['http_code'] != 201 &&  $info['http_code'] != 400) {
				echo "Received error: " . $info['http_code']. "\n";
				echo "Raw response:".$response."\n";

				exit();
		    }
		}
		return json_decode($response, TRUE);
	}
	
	
	
}