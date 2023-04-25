<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: ../../login.php");
  exit;
}

if (isset($_POST['updateCompte'])) {
      require_once "../../config.php";

      $id_c = $_POST['id_c'];
      
      $sql = "SELECT id_personne FROM compte  WHERE id_c = '$id_c' ";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $id_personne = $stmt->fetch(PDO::FETCH_ASSOC)['id_personne'];
      
      $Nom = $_POST["Nom"];
      $Prenom = $_POST["Prenom"];
      $sexe = $_POST["sexe"];
      $mail = $_POST["mail"];

      $sql = "UPDATE personne SET Nom='$Nom', Prenom='$Prenom', sexe='$sexe', mail='$mail' WHERE id_personne = '$id_personne'";
      $stmt = $pdo->prepare($sql);

      if ($stmt->execute()) {
            $_SESSION['status'] = "Modification de compte réussie";
            header("Location: listComptes.php");
      } else {
            $_SESSION['status'] = "Erreur";
            header("Location: listComptes.php");
      }
}