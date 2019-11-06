# ISPConfig Server Addons
## Autodiscover (Outlook) + Autoconfig (Thunderbird)

**NOTE:** This is a mirror for https://spicyhub.de/spicy-web/isp-mailconfig

02/11/2016 Djerk Geurts - Changed to make server configurable. Multiserver configurations aren't served well by pointing users at a single server. config.php now allows the use of a detected server hostname or a configured one. Plus general updates for ISPConfig 3.1.

06/11/2019 Conrad Sachweh - Handle Gnome Evolution and return static config for invalid inputs.

### Intro

Using this tool you can offer mailaccount autodiscover in Thunderbird and Outlook to all your customers in a multiserver environment.

### Placeholders
* my-service.com = The domain you run your "autodiscover" service on
* my-mail.com = The domain you want to activate autodiscover and autoconfig for
* PANEL-SERVER-IP = IP Address of the ISPConfig server (of course you can install the tool on any/every server in your environment)
	* In case of installing it on another server than the panel, you have to use another user and group instead of `ispapps` in vHost config and console commands. 

### Requirements

Outlook requires access to a SSL secured page with a trusted certificate. 

The example configuration uses the ISPConfig interface SSL certificate, for this to work it will have to be a valid publicly signed wildcard certificate. For example a StartSSL signed Level 2 (Personal Identity) certificate.

That should be enough for Outlook to work without error messages and warnings. 

## Setup

### Prepare ISPConfig

The discover plugin is not realized as Website managed by ISPConfig. This setup guide explains the setup of the vHost from scratch. So you can install it on any of your servers running a webserver.

Example configuration for Apache2 (Ubuntu 16.04)

* Add a new vHost Config file: `vi /etc/apache2/sites-available/discover.my-service.com.conf`

Content:

	<VirtualHost *:80>
	  ServerName discover.my-service.com
	  ServerAlias autoconfig.my-service.com
	  ServerAlias autoconfig.*
	  ServerSignature Off
	  
	  # Redirect non HTTPS and wrong domain names
	  RewriteEngine On
	  RewriteCond %{HTTPS} !on [OR]
	  RewriteCond %{HTTP_HOST} !^discover\.my-service\.com$
	  RewriteRule ^(.*)$ https://discover.my-service.com$1 [L,R]
	</VirtualHost>
	
	<VirtualHost *:443>
	  ServerName discover.my-service.com
	  ServerAlias autoconfig.my-service.com
	  ServerAlias autoconfig.*
	  ServerAdmin hostmaster@my-service.com
	  ServerSignature Off
	  
	  ErrorLog /var/log/ispconfig/httpd/discover.my-server.com/error.log
	
	  # Redirect client domains to my-service.com when connecting direct via HTTPS
	  RewriteEngine On
	  RewriteCond %{HTTP_HOST} !^discover\.my-service\.com$
	  RewriteRule ^(.*)$ https://discover.my-service.com$1 [L,R]
  
	  <IfModule mod_fcgid.c>
	    DocumentRoot /var/www/discover
	    SuexecUserGroup ispapps ispapps
	    <Directory /var/www/discover>
	      Options +Indexes +FollowSymLinks +MultiViews +ExecCGI
	      AllowOverride AuthConfig Indexes Limit Options FileInfo
      	      <FilesMatch "\.php$">
	        AddHandler fcgid-script .php
	      </FilesMatch>
	      FCGIWrapper /var/www/php-fcgi-scripts/apps/.php-fcgi-starter .php
	      Require all granted
	    </Directory>
	  </IfModule>
	
	  <IfModule mod_php5.c>
	    DocumentRoot /var/www/discover
	    AddType application/x-httpd-php .php
	    <Directory /var/www/mail_autoconfig>
	      Require all granted
	    </Directory>
	  </IfModule>
	
	  # This config uses the certificate that is used for ISPC Panel
	  # Change path if needed
	  SSLEngine On
	  SSLProtocol All -SSLv2 -SSLv3
	  # SSLCipherSuite          ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES128-SHA256:ECDHE-ECDSA-AES128-SHA:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA:ECDHE-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES256-SHA:ECDHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA:DHE-RSA-AES256-SHA256:DHE-RSA-AES256-SHA:ECDHE-ECDSA-DES-CBC3-SHA:ECDHE-RSA-DES-CBC3-SHA:EDH-RSA-DES-CBC3-SHA:AES128-GCM-SHA256:AES256-GCM-SHA384:AES128-SHA256:AES256-SHA256:AES128-SHA:AES256-SHA:DES-CBC3-SHA:!DSS
	  SSLHonorCipherOrder     on
	  SSLCertificateFile /usr/local/ispconfig/interface/ssl/ispserver.crt
	  SSLCertificateKeyFile /usr/local/ispconfig/interface/ssl/ispserver.key
	  # Always wise to include the cert chain, change as needed and uncomment
	  #SSLCertificateChainFile /usr/local/ispconfig/interface/ssl/startssl.chain.class2.server.crt
	</VirtualHost>


### Install the tool

* Enter your ISPConfig panel at **System -> Remote Users** and create a new remote user
* Privileges (ISPConfig 3.1 item names):
  * Server functions
  * Mail user functions
* Clone the repository into the discover-webfolder
* Copy the shipped config file
* Open it in your favorite editor and enter ISPC-URLs and Remote User credentials as well as the name of your service

Shell Commands:
 
    cd /var/www
    git clone https://github.com/dmgeurts/isp-mailconfig.git discover
	chown -R ispapps:ispapps discover
    cd discover
    cp config.dist.php config.php
    vi config.php

### DNS Config
Add the following DNS records for zone my-service.com:

* `A` `discover` -> `ISPConfig-SERVER-IP`  
  * maybe also `AAAA`, if IPv6 available for ISPConfig server
* `CNAME` `autoconfig` -> `discover`

Add the following DNS records for zone my-mail.com to enable autoconfig:

* `SRV` `_autodiscover._tcp` -> `1 10 443 discover.my-service.com` 
 * [SRV-Format on Route53:  [priority] [weight] [port] [server host name]]
* `CNAME` `autoconfig` -> `discover.my-service.com.`

### Testing

This tool works only for real existing mail accounts as it queries the ISPC Remote API for them.

While testing make shure to use adresses, that exist on your server.

#### Mozilla / Thunderbird
Enter [https://discover.my-service.com/mail/config-v1.1.xml?emailaddress=user%40my-mail.com](https://discover.my-service.com/mail/config-v1.1.xml?emailaddress=user%40my-mail.com) in your browser.

For an existing mail address in the emailaddress-parameter you should get an answer like this:

    <?xml version="1.0" encoding="UTF-8"?>
    <clientConfig version="1.1">
        <emailProvider id="my-mail.com">
            <domain>my-mail.com</domain>
            <displayName>YOUR SERIVCE NAME</displayName>
            <displayShortName>SERVICE</displayShortName>
            <incomingServer type="pop3">
                <hostname>mailserver.my-service.com</hostname>
                <port>995</port>
                <socketType>SSL</socketType>
                <authentication>password-cleartext</authentication>
                <username>user@my-mail.com</username>
                <pop3>
                    <leaveMessagesOnServer>true</leaveMessagesOnServer>
                    <downloadOnBiff>true</downloadOnBiff>
                    <daysToLeaveMessagesOnServer>10</daysToLeaveMessagesOnServer>
                </pop3>
            </incomingServer>
            <incomingServer type="imap">
                <hostname>mailserver.my-service.com</hostname>
                <port>993</port>
                <socketType>SSL</socketType>
                <authentication>password-cleartext</authentication>
                <username>user@my-mail.com</username>
            </incomingServer>
            <outgoingServer type="smtp">
                <hostname>mailserver.my-service.com</hostname>
                <port>587</port>
                <socketType>STARTTLS</socketType>
                <authentication>password-cleartext</authentication>
                <username>user@my-mail.com</username>
            </outgoingServer>
        </emailProvider>
    </clientConfig>

#### Microsoft Outlook
As Outlook posts an XML-File with user data to the server you can't just call it in browser to test it.

You can use Microsofts Remote Connectivity Analyzer at [https://testconnectivity.microsoft.com/ ](https://testconnectivity.microsoft.com/) to check if the **Outlook-AutoDiscovery** is working.

It takes some time but should also give a positive result for an existing Mail Account on my-mail.com.

### Credits
* Based on [the work](https://github.com/foe-services/ispc-resources/tree/master/guides/autodiscover) of [Christian Foellmann (cfoellmann)](https://github.com/cfoellmann)
* Rewritten by [Michael Fürmann](https://spicyhub.de/u/quest) from [Spicy Web](https://spicyweb.de)
* Adapted for ISPConfig 3.1, Apache 2.4 and server name setting added by [Djerk Geurts](https://djerk.nl/) from [Maizymoo](https://maizymoo.com/)
