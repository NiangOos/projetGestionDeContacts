<?php
$url = "http://localhost:8888/contacts.php";

// modifier le produit 1
$data = array(
    'nom' => 'Diaw2',
    'prenom' => 'Amadou2',
    'adresse' => 'Canada2',
    'email' => 'test@test.com2',
    'telephone' => '+1 299 2277 28882',
    'description' => 'Un super prof IT 2'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);

var_dump($response);

if (!$response) {
    return false;
}
