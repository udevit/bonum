<?php
// model
class Book
{
	public $name;
	public $year;
}

// create instance and set a book name
$book = new Book();
$book->name = 'test 2';

// initialize options
$options = array(
		'soap_version'=>SOAP_1_2,
		'exceptions'=>true,
		'trace'=>1,
		'cache_wsdl'=>WSDL_CACHE_NONE
);

try{
	// initialize SOAP client and call web service function
	$client = new SoapClient('http://127.0.0.1/soap/servidor_soap.php?wsdl',$options);
	$resp = $client->bookYear($book);
	
	// printing request
	echo "<b>REQUEST</b>:<br>" . htmlentities($client->__getLastRequest()) . "<br><br>";
	
	// printing response
	echo "<b>RESPONSE</b>:<br>" . htmlentities($client->__getLastResponse()) . "<br><br>";

	// dump response
	var_dump($resp);
	echo "<br><b>Year:</b> ".(int)$resp;
	
} catch (Exception $e) {
	echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}
?>