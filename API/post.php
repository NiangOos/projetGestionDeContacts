<?php
$url = 'http://localhost:8888/contacts.php';

$data = array(
    'nom' => 'Diaw',
    'prenom' => 'Amadou',
    'adresse' => 'Canada',
    'email' => 'test@test.com',
    'telephone' => '+1 299 2277 28882',
    'description' => 'Un super prof IT'
);

// utilisez 'http' même si vous envoyez la requête sur https:// ...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */
}

var_dump($result);
