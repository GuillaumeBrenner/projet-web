<?php
session_start();

if (isset($_POST['updateSubmit'])) {
      require_once "../../config.php";

      $id_entreprise = $_POST['id_entreprise'];

      $nom = $_POST["nom"];
      $nbr = $_POST["nbr"];

      $sql = "UPDATE entreprise SET nom='$nom', nombre_etudiant = '$nbr' WHERE id_entreprise = '$id_entreprise' ";

      $stmt = $pdo->exec($sql);

      if ($stmt) {
            $_SESSION['status'] = "Modification réussie";
            header("Location: listEntreprise.php");
      } 
      else {
            echo "erreur";
      }
}