<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config.php";

$id_c= $_POST['id_c'];

$sql = "UPDATE compte SET validite = 0 WHERE id_c = '$id_c' ";

$stmt = $pdo->exec($sql);

if ($stmt) {
    $_SESSION['status'] = "Compte supprimé";
      header("Location: listComptes.php");
} else {
    $_SESSION['supp'] = "Erreur de suppression";
    header("Location: listComptes.php");
}

?>