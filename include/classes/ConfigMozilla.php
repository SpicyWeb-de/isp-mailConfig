<?php
class ConfigMozilla extends AutoConfig{

	protected $response_template = 'config-v1.1.xml.php';
	protected $response_type = 'text/xml';

	public function __construct(){
		$this->email = urldecode($_GET['emailaddress']);
		try {
		    $this->loadData();
		} catch (UnkownUser $e) {
		  /*
		  this actually works for e.g. Gnome Evolution, they are
		  more privacy concerned and are sending
		  `emailaddress=EVOLUTIONUSER%40domain.de&emailmd5=XXX`
		  just returning the static emailaddress is sufficient
		  */
		    $this->host = ["hostname" => "mail.bnbhosting.de"];
		    $this->user = ["email" => $this->email,
				   "login" => $this->email];
		  }
	}

}
?>