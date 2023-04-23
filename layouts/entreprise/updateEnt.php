<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config.php";


if (isset($_POST['updateSubmit'])) {

      $id_entreprise = $_POST['id_entreprise'];

      $nom = $_POST["nom"];
      $nbr = $_POST["nbr"];

      $sql = "UPDATE entreprise SET nom = '$nom', nombre_etudiant = '$nbr' WHERE id_entreprise = '$id_entreprise' ";

      $stmt = $pdo->exec($sql);

      if ($stmt) {
            $_SESSION['status'] = "Modification réussie";
            header("Location: listEntreprise.php");
      } 
      else {
            $_SESSION['supp'] = "Une erreur est survenue, Veuillez réessayer";
            header("Location: listEntreprise.php");
      }
}