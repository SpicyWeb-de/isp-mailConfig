<?php
class ConfigOutlook extends AutoConfig{
	
	protected $response_template = 'outlook.xml.php';
	protected $response_type = 'text/xml';
	
	public function __construct(){
		//Lese den Body der XML-Anfrage von Outlook aus
		$xmlObj = simplexml_load_string(file_get_contents('php://input'));
		//Suche in der XML-Antwort die E-Mailadresse raus
		$arraydata = (array) $xmlObj;
		$arraydata = (array) $arraydata["Request"];
		$this->email = $arraydata["EMailAddress"];
		$this->loadData();
	}
	
}
?>