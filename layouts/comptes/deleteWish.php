<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config.php";

$sql = "SELECT id_c FROM compte WHERE login ='" . $_SESSION["username"] ."';" ;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$id_c = $stmt->fetch(PDO::FETCH_ASSOC)['id_c'];

$req = $pdo->prepare("DELETE FROM wishlist WHERE id_offre = :id_offre AND id_c = :id_c");
$req->bindParam(":id_c", $id_c);
$req->bindParam(":id_offre", $_POST['id_o']);
$req->execute();

if ($req->execute()) {
    $_SESSION['status'] = "Offre retirée de votre liste de souhaits";
      header("Location: profil.php");
} else {
    $_SESSION['supp'] = "Erreur de suppression";
    header("Location: profil.php");
}

?>