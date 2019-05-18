<?php
	//Definen las opciones para invocacion
	$options = array(
			'location' => "http://www.dneonline.com/calculator.asmx",
			'uri'=> "http://tempuri.org/",
			'soap_version'=>SOAP_1_2,
			'exceptions'=>true,
			'trace'=>1,
			'cache_wsdl'=>WSDL_CACHE_NONE
	);
	
	try
	{
		//Inicializando el cliente
		$client = new SoapClient(NULL, $options);
		
		//Se especifican los parametros a enviar y se invoca al WS SOAP
		$resp = $client->__soapCall("Add",
			array(new SoapParam(new SoapVar(10, XSD_INTEGER), 'ns1:intA'),
			      new SoapParam(new SoapVar(5, XSD_INTEGER), 'ns1:intB')
			),
			array('soapaction' => 'http://tempuri.org/Add')
		);
		
		//Invoca al WS SOAP
		//$resp = $client->Add($add);
		
		//Imprimir los request & response
		echo "REQUEST: ".htmlentities($client->__getLastRequest())."<br><br>";
		
		echo "RESPONSE: ".htmlentities($client->__getLastResponse());
		
		//Imprimiendo el objeto
		var_dump($resp);
		
		//Imprimir el valor
		echo "Imprimir Valor: ".$resp;
		//echo "Imprimir Valor: ".$resp->AddResult;
		
	}catch(Exception $e)
	{
		echo "<b>Error: </b>".$e->getMessage();
	}	
?>
