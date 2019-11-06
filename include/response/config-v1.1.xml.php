<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>

<clientConfig version="1.1">
    <emailProvider id="<?php echo substr($this->user['email'], strpos($this->user['email'], '@')+1) ?>">
        <domain><?php echo substr($this->user['email'], strpos($this->user['email'], '@')+1) ?></domain>
        <displayName><?php echo SERVICE_NAME.(SERVICE_ADDR === TRUE ? ' - '.($this->user['login']) : '') ?></displayName>
        <displayShortName><?php echo SERVICE_SHORT ?></displayShortName>
        // Change order to indicate preference to clients
        <incomingServer type="imap">
            <hostname><?php echo (defined('SERVER_FQDN') ? SERVER_FQDN : $this->host['hostname']) ?></hostname>
            <port>993</port>
            <socketType>SSL</socketType>
            <authentication>password-cleartext</authentication>
            <username><?php echo $this->user['login'] ?></username>
        </incomingServer>
        <incomingServer type="pop3">
            <hostname><?php echo (defined('SERVER_FQDN') ? SERVER_FQDN : $this->host['hostname']) ?></hostname>
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
        // Prefer SSL over STARTTLS
        <outgoingServer type="smtp">
            <hostname><?php echo (defined('SERVER_FQDN') ? SERVER_FQDN : $this->host['hostname']) ?></hostname>
            <port>465</port>
            <socketType>SSL</socketType>
            <authentication>password-cleartext</authentication>
            <username><?php echo $this->user['login'] ?></username>
        </outgoingServer>
        // Provide STARTTLS as a fallback
        <outgoingServer type="smtp">
            <hostname><?php echo (defined('SERVER_FQDN') ? SERVER_FQDN : $this->host['hostname']) ?></hostname>
            <port>587</port>
            <socketType>STARTTLS</socketType>
            <authentication>password-cleartext</authentication>
            <username><?php echo $this->user['login'] ?></username>
        </outgoingServer>
    </emailProvider>
</clientConfig>
