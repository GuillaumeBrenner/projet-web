<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

var_dump($_POST);

$id = $_POST['id_entreprise'];

$del_c = $pdo->prepare("UPDATE entreprise SET validite = 0 WHERE id_entreprise = :id");
$del_c->bindParam(":id", $id);
$del_c->execute();

$newURL = "listEntreprise.php";

header('Location: '.$newURL);

?>