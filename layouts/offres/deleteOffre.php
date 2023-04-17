<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config.php";

$id_o = $_POST['id_o'];

$sql = "UPDATE offre SET valide = 0 WHERE id_offre = '$id_o' ";

$stmt = $pdo->exec($sql);

if ($stmt) {
    $_SESSION['status'] = "Donnée supprimée";
      header("Location: listOffre.php");
} else {
    $_SESSION['supp'] = "Erreur de suppression";
    header("Location: listOffre.php");
}

?>