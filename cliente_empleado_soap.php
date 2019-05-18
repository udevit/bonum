<?php
	//modelo
	class Empleado{
		public $id;
		public $rfc;
		public $nombre;
		
		function __construct($id, $rfc, $nombre)
		{
			$this->id = $id;
			$this->rfc = $rfc;
			$this->nombre = $nombre;
		}
	}
	
	$options = array(
			'soap_version'=>SOAP_1_2,
			'exceptions'=>true,
			'trace'=>1,
			'cache_wsdl'=>WSDL_CACHE_NONE
	);

	try
	{
		//inicializar Cliente
		$client = new SoapClient('http://127.0.0.1/ejemplos/empleado_soap.php?wsdl', $options);
		$resp = $client->listarEmpleados();
		
		//Imprimir los request & response
		echo "REQUEST: ".htmlentities($client->__getLastRequest())."<br><br>";
		
		echo "RESPONSE: ".htmlentities($client->__getLastResponse());
		
		//Imprimiendo el objeto
		var_dump($resp);
		
		echo '<br><br><br>';
		$array = json_decode(json_encode($resp), true);
		var_dump($array);
		
		echo '<br><br><br>';
		var_dump($array['Struct']);
		
		echo '<br><br><br>';
		
		//imprimiendo los valores del array manualmente
		print_r($array['Struct']['0']['enc_value']['nombre']);
		echo '<br>';
		print_r($array['Struct']['1']['enc_value']['nombre']);
		
		//recorriendo el array
		/*foreach($array['Struct'] as $item) {
			echo '<pre>'.$item['enc_value']['nombre'];
		}*/
		
	}catch(Exception $e)
	{
		echo "Error: ".$e->getMessage();
	}
?>