<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

try {
$sql = "SELECT id_c FROM compte WHERE login ='" . $_SESSION["username"] ."';" ;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$id_c = $stmt->fetch(PDO::FETCH_ASSOC)['id_c'];

$req = $pdo->prepare("INSERT INTO wishlist (id_c , id_offre) VALUES ( :id_c , :id_offre)");
$req->bindParam(":id_c", $id_c);
$req->bindParam(":id_offre", $_POST['id_offre']);

if ($req->execute()) {
      $_SESSION['status'] = "Offre ajoutée à la liste des souhaits";
        header("Location: listOffre.php");
  } else {
      $_SESSION['supp'] = "Oups, veuillez réessayer";
      header("Location: listOffre.php");
  }
} 
catch(PDOException $e) {
      $_SESSION['supp'] = "L'offre existe déjà dans votre liste des souhaits";
      header("Location: listOffre.php");
}