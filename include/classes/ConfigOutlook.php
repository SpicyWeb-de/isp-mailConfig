<?php
class ConfigOutlook extends AutoConfig{

	protected $response_template = 'autodiscover.xml.php';
	protected $response_type = 'text/xml';

	public function __construct(){
        $data = file_get_contents("php://input");
        preg_match("/\<EMailAddress\>(.*?)\<\/EMailAddress\>/", $data, $matches);
        $this->email = $matches[1];
	try {
            $this->loadData();
	} catch (UnkownUser $e) {
	    $this->host = ["hostname" => "mail.bnbhosting.de"];
	    $this->user = ["login" => $this->email];
	  }
	}

}
?>