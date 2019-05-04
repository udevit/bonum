<?php
// model
class Add
{
	public $intA;
	public $intB;
}

// create instance and set a value of the numbers
$add = new Add();
$add->intA = 10;
$add->intB = 5;

// initialize options
$options = array(
		'soap_version'=>SOAP_1_2,
		'exceptions'=>true,
		'trace'=>1,
		'cache_wsdl'=>WSDL_CACHE_NONE
);

try{
	// initialize SOAP client and call web service function
	$client = new SoapClient('http://www.dneonline.com/calculator.asmx?WSDL',$options);
	$resp = $client->Add($add);
	
	// printing request
	echo "<b>REQUEST</b>:<br>" . htmlentities($client->__getLastRequest()) . "<br><br>";
	
	// printing response
	echo "<b>RESPONSE</b>:<br>" . htmlentities($client->__getLastResponse()) . "<br><br>";

	// dump response
	var_dump($resp);
	echo "<br><b>Result:</b> ".(int)$resp->AddResult;
	
} catch (Exception $e) {
	echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}
?>