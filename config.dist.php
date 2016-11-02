<?php
// Panel connection
define('SOAP_USER', 'REMOTE_USER');
define('SOAP_PASS', 'REMOTE_PASS');
define('SOAP_LOCATION', 'https://SERVER.TLD:8080/remote/index.php');
define('SOAP_URI', 'https://SERVER.TLD:8080/remote/');

// About your service
define('SERVICE_NAME', 'My Mail Service');
define('SERVICE_SHORT', 'MyMail');
define('SERVER_FQDN', echo $this->host['hostname'];
#define('SERVER_FQDN', 'mail.my-service.com');
?>
