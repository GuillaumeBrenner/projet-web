<?php

session_start();

// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
require_once "../../config.php";

var_dump($_POST);

$sql = "SELECT id_c FROM compte WHERE login ='" . $_SESSION["username"] ."';" ;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$id_c = $stmt->fetch(PDO::FETCH_ASSOC)['id_c'];

$tmpName = $_FILES["cv"]['tmp_name'];
$name = $_FILES["cv"]['name'];
$size = $_FILES["cv"]['size'];
$error = $_FILES["cv"]['error'];
$tabExtension = explode('.', $name);
$extension = strtolower(end($tabExtension));
$uniqueName = uniqid('', true);
$file = $uniqueName.".".$extension;
move_uploaded_file($tmpName, '../../upload/cv/'.$file);

$cv = '../comptes/upload/cv/'.$file;

if ($size == 0) {
    $cv = '';
}

$tmpName = $_FILES["ldm"]['tmp_name'];
$name = $_FILES["ldm"]['name'];
$size = $_FILES["ldm"]['size'];
$error = $_FILES["ldm"]['error'];
$tabExtension = explode('.', $name);
$extension = strtolower(end($tabExtension));
$uniqueName = uniqid('', true);
$file = $uniqueName.".".$extension;
move_uploaded_file($tmpName, '../../upload/ldm/'.$file);

$ldm = '../../upload/ldm/'.$file;

if ($size == 0) {
    $ldm = '';
}


$req = $pdo->prepare("INSERT INTO postule ( id_c , id_offre , cv , ldm ) VALUES ( :id_c , :id_offre , :cv , :ldm )");
$req->bindParam(":id_c", $id_c);
$req->bindParam(":id_offre", $_POST['id_offre']);
$req->bindParam(":cv", $cv);
$req->bindParam(":ldm", $ldm);
$req->execute();
