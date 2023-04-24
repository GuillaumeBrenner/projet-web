<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

if (isset($_POST['insertOffre'])) {
      
      try {
            $validite = 1;
      
            $titre = $_POST["Titre"];
            $description = $_POST["Description"];
            $duree = $_POST["Durée"];
            $date_post = $_POST["Date_post"];
            $nombre_places = $_POST["nombre_places"];
            $remuneration = $_POST["Rémunération"];
            $entreprise = $_POST["entreprise"];
            $site = $_POST["site"];
      
            $sql = "INSERT INTO offre(Titre, descrip , Durée, Date_post, nombre_places, Remuneration, valide, id_site) VALUES(:titre, :descrip, :duree, :date_post, :nombre_places, :remuneration, :validite, :site)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':descrip', $description);
            $stmt->bindParam(':duree', $duree);
            $stmt->bindParam(':date_post', $date_post);
            $stmt->bindParam(':nombre_places', $nombre_places);
            $stmt->bindParam(':remuneration', $remuneration);
            $stmt->bindParam(':validite', $validite);
            $stmt->bindParam(':site', $site);
            
            if ($stmt->execute()) {
                  $_SESSION['status'] = "Offre ajoutée";
                  header("Location: listOffre.php");
            } else {
                  $_SESSION['supp'] = "Erreur";
                  header("Location: listOffre.php");
            }
      } catch (PDOException $e) {
            $_SESSION['supp'] = "Une erreur est survenue, veuillez réessayer";
            header("Location: listOffre.php");
      }

}