<?php

// class pour lire le fichier de config (config.xml)
class PaypalMiniKit_ConfigReader {
	public static function get(){
		$file_name_config_xml = './paypalminikit/config.xml' ;
		if( file_exists( $file_name_config_xml ) ){
			
			$xml_config = simplexml_load_file( $file_name_config_xml );
			$config					=	[
				'clientid'		=>	(string)( $xml_config->paypalaccess->clientid ),
				'secretkey'		=>	(string)( $xml_config->paypalaccess->secretkey ),
				'domainname'	=>	(string)( $xml_config->paypalaccess->domainname ),
				'successurl'	=>	(string)( $xml_config->paypalaccess->successurl ),
				'cancelurl'	=>	(string)( $xml_config->paypalaccess->cancelurl ),
			];
		}
		return $config;
	}
}