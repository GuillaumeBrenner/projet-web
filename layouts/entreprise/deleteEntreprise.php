<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

$id_ent = $_POST['id_ent'];

$sql = "UPDATE entreprise SET validite = 0 WHERE id_entreprise = '$id_ent' ";

$stmt = $pdo->exec($sql);

if ($stmt) {
    $_SESSION['status'] = "Donnée supprimée";
      header("Location: listEntreprise.php");
} else {
    $_SESSION['supp'] = "Erreur de suppression";
    header("Location: listEntreprise.php");
}

?>