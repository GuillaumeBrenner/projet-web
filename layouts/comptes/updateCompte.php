<?php
session_start();

if (isset($_POST['updateCompte'])) {
      require_once "../../config.php";

      $id_p = $_POST['id_personne'];

      $Nom = $_POST["Nom"];
      $Prenom = $_POST["Prenom"];
      $sexe = $_POST["sexe"];


      $sql = "UPDATE personne SET Nom='$Nom', Prenom='$Prenom', sexe='$sexe' WHERE id_personne = '$id_p'";

      $stmt = $pdo->exec($sql);

      if ($stmt) {
            $_SESSION['status'] = "Modification de compte réussie";
            header("Location: listComptes.php");
      } else {
            $_SESSION['status'] = "Erreur";
            header("Location: listComptes.php");
      }
}