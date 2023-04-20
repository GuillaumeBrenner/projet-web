<?php
session_start();

if (isset($_POST['updateOffre'])) {
      require_once "../../config.php";
      
      $validite = 1;
      
      $id_offre = $_POST['id_offre'];
      
      $titre = $_POST["Titre"];
      $description = $_POST["descrip"];
      $duree = $_POST["Durée"];
      $date_post = $_POST["Date_post"];
      $nombre_places = $_POST["nombre_places"];
      $remuneration = $_POST["Rémunération"];
      $site = $_POST["site"];;

      $sql = "UPDATE offre SET Titre='$titre', descrip='$description', Durée='$duree', Date_post=' $date_post', nombre_places=' $nombre_places',
      Remuneration='  $remuneration', valide = '$validite', id_site = '$site'  WHERE id_offre = '$id_offre'  ";

      $stmt = $pdo->exec($sql);
      
      if ($stmt) {
            $_SESSION['status'] = "Modification réussie";
            header("Location: listOffre.php");
      } else {
            $_SESSION['status'] = "une Erreur est survenue, Veuillez réessayer plus tard";
            header("Location: listOffre.php");
      }
}