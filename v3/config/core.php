<?php
	// mostrar el reportte de error
	error_reporting(E_ALL);
	 
	// establecer el time-zone por default
	date_default_timezone_set('America/Mexico_City');
	 
	// variables usadas por jwt
	$key = "example_key";
	$issuer_claim = "http://bonum.org";
	$audience_claim = "http://bonum.com";
	$issuedat_claim = time(); // creado en
	$notbefore_claim = $issuedat_claim + 10; //no antes end segundos
	$expire_claim = $issuedat_claim + 60; // tiempo de expiracion en segundos
?>
