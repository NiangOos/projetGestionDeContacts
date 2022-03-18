<?php
// Se connecter à la base de données
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            // Récupérer un seul produit
            $id = intval($_GET["id"]);
            getContacts($id);
        } else {
            // Récupérer tous les produits
            getContacts();
        }
        break;
    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
    case 'POST':
        // Ajouter un produit
        AddProduct();
        break;
    case 'PUT':
        // Modifier un produit
        $id = intval($_GET["id"]);
        updateProduct($id);
        break;
    case 'DELETE':
        // Supprimer un produit
        $id = intval($_GET["id"]);
        deleteProduct($id);
        break;
}

function getContacts()
{
    global $conn;
    $query = "SELECT * FROM contacts";
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}


function getContact($id = 0)
{
    global $conn;
    $query = "SELECT * FROM contacts";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function AddProduct()
{
    global $conn;
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $description = $_POST["description"];


    echo $query = "INSERT INTO contacts (nom, prenom, adresse, email, telephone, description) VALUES ('$nom', '$prenom', '$adresse', '$email', '$telephone', '$description')";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'contact ajoute avec succes.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'ERREUR!.' . mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateProduct($id)
{
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);
    $nom = $_PUT["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $description = $_POST["description"];

    //construire la requête SQL
    $query = "UPDATE contacts SET nom = '$nom', prenom = '$prenom', adresse = '$adresse', email = '$email', telephone = '$telephone', description = '$description' WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Produit mis a jour avec succes.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Echec de la mise a jour de produit. ' . mysqli_error($conn)
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function deleteProduct($id)
{
    global $conn;
    $query = "DELETE FROM contacts WHERE id=" . $id;
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Produit supprime avec succes.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'La suppression du produit a echoue. ' . mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
