<?php
session_start();

if (isset($_POST['updateProfil'])) {
      require_once "../../config.php";

      $id_c = $_POST['id_c'];
      $id_p = $_POST['id_p'];

      $Nom = $_POST["Nom"];
      $Prenom = $_POST["Prenom"];
      $sexe = $_POST["sexe"];
      $centre = $_POST["centre"];
      $login = $_POST["login"];
      $mdp = $_POST["mdp"];


      $sql = "UPDATE personne SET Nom='$Nom', Prenom='$Prenom', sexe='$sexe' WHERE id_personne = '$id_p'";
      
      $updateCompte = "UPDATE compte SET login='$login', mdp='$mdp' WHERE id_c = '$id_c'";

      $stmt = $pdo->exec($sql);
      $stmtCompte = $pdo->exec($updateCompte);
      
      if ($stmt && $stmtCompte) {
            session_destroy();
            $_SESSION['status'] = "Modification des informations de connexion réussie, Veuillez vous reconnecter";
            header("Location: ../../login.php");
      } else if ($stmt){
            $_SESSION['status'] = "Modification réussie";
            header("Location: profil.php");
      } else if ($stmtCompte) {
            session_destroy();
            header("Location: ../../login.php");
      } else {
            $_SESSION['status'] = "Erreur";
            header("Location: profil.php");
      }
}