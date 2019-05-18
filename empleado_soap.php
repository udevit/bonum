<?php
	//deshabilitar la opcion de wsdl cache
	ini_set("soap.wsdl_cache_enabled","0");

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
	
	function listarEmpleados()
	{
		$empleado = new Empleado(1, 'cagx123456678', 'Olegario Castellanos Guzman');
		$empleado2 = new Empleado(2, 'peca8987655', 'Pedro Castillo Fuentes');
	
		$lista = array($empleado, $empleado2);
		
		return $lista;
	}

	//Inicializar el servidor SOAP
	$server = new SoapServer('empleado.wsdl', [
			'classmap'=>[
				'empleado'=>'Empleado'
			]
	]);
	
	//Registrar la funcion/operacion del WS
	$server->addFunction('listarEmpleados');
	
	//Iniciar el WS
	$server->handle();

?>