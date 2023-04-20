<?php

session_start();
require_once "../../config.php";

if (isset($_POST['insertOffre'])) {
      
      $validite = 1;
      
      $titre = $_POST["Titre"];
      $description = $_POST["Description"];
      $duree = $_POST["Durée"];
      $date_post = $_POST["Date_post"];
      $nombre_places = $_POST["nombre_places"];
      $remuneration = $_POST["Rémunération"];
      $entreprise = $_POST["entreprise"];
      $site = $_POST["site"];

      $sql = "INSERT INTO offre(Titre, descrip , Durée, Date_post, nombre_places, Remuneration, valide, id_site) VALUES('$titre','$description','$duree', '$date_post', '$nombre_places', '$remuneration', '$validite', '$site')";
       
      $stmt = $pdo->exec($sql);
      
      if ($stmt) {
            $_SESSION['status'] = "Offre ajoutée";
            header("Location: listOffre.php");
      } else {
            $_SESSION['status'] = "Erreur";
            header("Location: listOffre.php");
      }
}