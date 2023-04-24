<?php
session_start();

if (isset($_POST['updateOffre'])) {

      try {
            require_once "../../config.php";
            
            $id_offre = $_POST['id_offre'];
            
            $titre = $_POST["Titre"];
            $duree = $_POST["Durée"];
            $date_post = $_POST["Date_post"];
            $nombre_places = $_POST["nombre_places"];
            $remuneration = $_POST["Rémunération"];
            $description = $_POST["descrip"];
            $site = $_POST["site"];
            $validite = 1;
      
            $sql = "UPDATE offre SET Titre='$titre', Durée='$duree', Date_post=' $date_post', nombre_places=' $nombre_places',
            Remuneration='$remuneration', valide = '$validite', descrip='$description', id_site='$site'  WHERE id_offre='$id_offre'  ";
      
            $stmt = $pdo->exec($sql);
            
            if ($stmt) {
                  $_SESSION['status'] = "Modification réussie";
                  header("Location: listOffre.php");
            } else {
                  $_SESSION['status'] = "une Erreur est survenue, Veuillez réessayer plus tard";
                  header("Location: listOffre.php");
            }
      }  catch (PDOException $e) {
            $_SESSION['supp'] = "Une erreur est survenue, veuillez réessayer";
            header("Location: listOffre.php");
      }
}