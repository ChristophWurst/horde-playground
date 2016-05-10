<?php

require_once './vendor/autoload.php';

$client = new Horde_Imap_Client_Socket([
    'username' => 'user@domain.tld',
    'password' => 'mypassword',
    'hostspec' => 'localhost',
    'port' => '993',
    'secure' => 'ssl',
    'debug' => '/tmp/horde-playground.log'
	]);

$client->login();

$mailboxName = md5(time());
$mailbox = $client->createMailbox($mailboxName);

$max = 5000;
for ($i = 1; $i <= $max; $i++) {
	$mail = <<<EOM
From: John Doe <example@example.com>
Subject: Test message $i
MIME-Version: 1.0
Content-Type: multipart/mixed;
        boundary="XXXXboundary text"

This is a multipart message in MIME format.

--XXXXboundary text 
Content-Type: text/plain

this is the body text

--XXXXboundary text 
Content-Type: text/plain;
Content-Disposition: attachment;
        filename="test.txt"

this is the attachment text

--XXXXboundary text--
EOM;

	$client->append($mailboxName, [
	    [
		'data' => $mail
	    ]
	]);

	echo "$i/$max messages saved (" . $i / $max * 100 . "%)\n";
}
echo "added $i messages to $mailboxName\n";
