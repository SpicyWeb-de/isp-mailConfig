<?php
// Panel connection
define('SOAP_USER', 'REMOTE_USER');
define('SOAP_PASS', 'REMOTE_PASS');
define('SOAP_LOCATION', 'https://SERVER.TLD:8080/remote/index.php');
define('SOAP_URI', 'https://SERVER.TLD:8080/remote/');

// About your service
define('SERVICE_NAME', 'My Mail Service');
define('SERVICE_ADDR', true ); // Add the client email to the Service name? (true/false)
define('SERVICE_SHORT', 'MyMail');
//define('FALLBACK_SERVER_FQDN', 'mail.SERVER.TLD'); // Servername to send back if user is not known, defaults to $_SERVER['SERVER_NAME']
//define('SMTP_SERVER_FQDN', 'mail.SERVER.TLD'); // Uncomment to use, autodetects the server name otherwise.
//define('IMAP_SERVER_FQDN', 'mail.SERVER.TLD'); // Uncomment to use, autodetects the server name otherwise.
//define('POP_SERVER_FQDN', 'mail.SERVER.TLD'); // Uncomment to use, autodetects the server name otherwise.
?>
