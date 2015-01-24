<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>

<clientConfig version="1.1">
    <emailProvider id="<?php echo substr($this->user['email'], strpos($this->user['email'], '@')+1) ?>">
        <domain><?php echo substr($this->user['email'], strpos($this->user['email'], '@')+1) ?></domain>
        <displayName><?php echo SERVICE_NAME ?></displayName>
        <displayShortName><?php echo SERVICE_SHORT ?></displayShortName>
        <incomingServer type="pop3">
            <hostname><?php echo $this->host['hostname'] ?></hostname>
            <port>995</port>
            <socketType>SSL</socketType>
            <authentication>password-cleartext</authentication>
            <username><?php echo $this->user['login'] ?></username>
            <pop3>
                <leaveMessagesOnServer>true</leaveMessagesOnServer>
                <downloadOnBiff>true</downloadOnBiff>
                <daysToLeaveMessagesOnServer>10</daysToLeaveMessagesOnServer>
            </pop3>
        </incomingServer>
        <incomingServer type="imap">
            <hostname><?php echo $this->host['hostname'] ?></hostname>
            <port>993</port>
            <socketType>SSL</socketType>
            <authentication>password-cleartext</authentication>
            <username><?php echo $this->user['login'] ?></username>
        </incomingServer>
        <outgoingServer type="smtp">
            <hostname><?php echo $this->host['hostname'] ?></hostname>
            <port>587</port>
            <socketType>STARTTLS</socketType>
            <authentication>password-cleartext</authentication>
            <username><?php echo $this->user['login'] ?></username>
        </outgoingServer>
    </emailProvider>
</clientConfig>