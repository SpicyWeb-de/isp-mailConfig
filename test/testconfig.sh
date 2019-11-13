#!/bin/bash

HOST="discover.host.de"

# outlook
echo "Outlook"
curl -k -X POST -d @outlook.xml https://$HOST/autodiscover/autodiscover.xml
curl -k -X POST -d @eas.xml https://$HOST/autodiscover/autodiscover.xml

# thunderbird
echo "Thunderbird"
# should get posted address back
curl "https://$HOST/mail/config-v1.1.xml?emailaddress=test%40example.com"

# evolution
echo "Evolution"
curl "https://$HOST/mail/config-v1.1.xml?emailaddress=EMAILADDR%40example.com" 
