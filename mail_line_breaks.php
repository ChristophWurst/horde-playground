<?php

require __DIR__ . '/vendor/autoload.php';

$transport = new Horde_Mail_Transport_Mock();

$headers = [
    'From' => 'from@example.com',
    'To' => 'to@example.com',
    'Subject' => 'test message',
];
$content = <<<EOF
Farm-to-table forage fashion axe, affogato chartreuse lumbersexual sartorial. Put a bird on it PBR&B meggings, waistcoat austin asymmetrical blue bottle pinterest tacos disrupt meh. Actually cardigan post-ironic organic tousled. Brunch literally street art keffiyeh butcher, godard hammock vegan drinking vinegar man braid four loko wayfarers tousled. Polaroid gentrify small batch scenester poutine meggings fap migas. Celiac slow-carb semiotics trust fund, fingerstache hoodie vegan truffaut leggings viral. Green juice hella tilde, flannel messenger bag selvage VHS trust fund.	
EOF;

echo "before: $content\n\n";

$mail = new Horde_Mime_Mail();
$mail->addHeaders($headers);
$mail->setBody($content);

$mail->send($transport);

$raw = $mail->getRaw();
rewind($raw);
echo stream_get_contents($raw);