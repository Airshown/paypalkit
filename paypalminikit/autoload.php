<?php

spl_autoload_register( function ( $class ) {
	$file = strtolower( "PaypalMiniKit\\".$class.".php" );
    if ( file_exists( $file ) ) {
        require $file;
	}
});
