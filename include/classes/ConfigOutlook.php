<?php
class ConfigOutlook extends AutoConfig{

    protected $response_template = 'autodiscover.xml.php';
    protected $response_type = 'text/xml';

    public function __construct(){
        $data = file_get_contents("php://input");
        $matchCount = preg_match("/\<EMailAddress\>(.*?)\<\/EMailAddress\>/", $data, $matches);
        try {
            if ($matchCount > 0) {
                $this->email = $matches[1];
            } else {
                throw new UnkownUser("No user found in XML");
            }
            $this->loadData();
        } catch (UnkownUser $e) {
            $this->host = ["hostname" => defined('FALLBACK_SERVER_FQDN') ? FALLBACK_SERVER_FQDN : $_SERVER['SERVER_NAME']];
            $this->user = ["login" => $this->email];
        }
    }

}
?>