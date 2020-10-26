<?php
class UnkownUser extends Exception {};
class AutoConfig{

    protected static $_files = array();
    protected static $_default = '';

    protected $email = false;
    protected $user = false;
    protected $host = false;

    public static function get($requested_file = ''){
        if(!array_key_exists($requested_file, self::$_files))
            $requested_file = self::$_default;
        $instance = new self::$_files[$requested_file]();
        return $instance;
    }

    public static function addFile($file, $class){
        self::$_files[$file] = $class;
    }

    public static function setDefault($file){
        self::$_default = $file;
    }

    protected function loadData(){
        $client = new SoapClient(null, array('location' => SOAP_LOCATION,
            'uri'      => SOAP_URI,
            'stream_context'=> stream_context_create(array('ssl'=> array('verify_peer'=>false,'verify_peer_name'=>false))) // mitigate ssl issues
             ));
        try {
            //* Login to the remote server
            if($session_id = $client->login(SOAP_USER,SOAP_PASS)) {
                $mail_user = $client->mail_user_get($session_id, array('email' => $this->email));
                if(count($mail_user) == 1)
                {
                    $this->host = $client->server_get($session_id, $mail_user[0]['server_id'], 'server');
                    $this->user = $mail_user[0];
                }
                else
                    throw new UnkownUser("Unknown Account");
            }

            //* Logout
            $client->logout($session_id);

        } catch (SoapFault $e) {
            throw new Exception('SOAP Error: '.$e->getMessage());
        }
    }

    public function response(){
        if(!$this->email OR !$this->user OR !$this->host)
            throw new Exception('You must load data before forming response!');
        ob_start();
        include 'include/response/'.$this->response_template;
        $response = ob_get_contents();
        ob_end_clean();
        header("Content-type: ".$this->response_type);
        echo $response;
    }
}
?>
