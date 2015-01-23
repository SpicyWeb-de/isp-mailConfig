<?php
class ConfigMozilla extends AutoConfig{
	
	protected $response_template = 'config-v1.1.xml.php';
	protected $response_type = 'text/xml';
	
	public function __construct(){
		$this->email = $_GET['emailaddress'];
		$this->loadData();
	}
	
}
?>