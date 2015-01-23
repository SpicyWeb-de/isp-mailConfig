<Autodiscover xmlns="http://schemas.microsoft.com/exchange/autodiscover/responseschema/2006">
    <Response xmlns="http://schemas.microsoft.com/exchange/autodiscover/outlook/responseschema/2006a">
        <Account>
            <AccountType>email</AccountType>
            <Action>settings</Action>
            <Protocol>
                <Type>IMAP</Type>
                <Server><? echo $mail_server['hostname'] ?></Server>
                <Port>993</Port>
                <DomainRequired>off</DomainRequired>
                <LoginName><? echo $mail_user['login'] ?></LoginName>
                <SPA>off</SPA>
                <SSL>on</SSL>
                <AuthRequired>on</AuthRequired>
            </Protocol>
            <Protocol>
                <Type>POP3</Type>
                <Server><? echo $mail_server['hostname'] ?></Server>
                <Port>995</Port>
                <DomainRequired>off</DomainRequired>
                <LoginName><? echo $mail_user['login'] ?></LoginName>
                <SPA>off</SPA>
                <SSL>on</SSL>
                <AuthRequired>on</AuthRequired>
            </Protocol>
            <Protocol>
                <Type>SMTP</Type>
                <Server><? echo $mail_server['hostname'] ?></Server>
                <Port>25</Port>
                <DomainRequired>off</DomainRequired>
                <LoginName><? echo $mail_user['login'] ?></LoginName>
                <SPA>off</SPA>
                <Encryption>TLS</Encryption>
                <AuthRequired>on</AuthRequired>
                <UsePOPAuth>off</UsePOPAuth>
                <SMTPLast>off</SMTPLast>
            </Protocol>
        </Account>
    </Response>
</Autodiscover>