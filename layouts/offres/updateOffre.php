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
      $idVille = $_POST["ville"];
      $idEntreprise = $_POST["entreprise"];

      //recupération de l'id du site 
      $Sitereq = "SELECT id_site FROM 
      site s
      INNER JOIN entreprise e ON e.id_entreprise = s.id_entreprise
      INNER JOIN ville v ON v.id_ville = s.id_ville
      WHERE e.id_entreprise = '" . $idEntreprise . "' and v.id_ville = '" . $idVille . "' ";

      $idSite = $pdo->query($Sitereq);

      if ($idSite->fetch()) {
            $site = $pdo->query($Sitereq)->fetch()['id_site'];
      };

      $sql = "UPDATE offre SET Titre='$titre', descrip='$description', Durée='$duree', Date_post=' $date_post', nombre_places=' $nombre_places',
      Remuneration='  $remuneration', valide = '$validite'  WHERE id_offre = '$id_offre'  ";

      $stmt = $pdo->exec($sql);
      if ($stmt) {
            $_SESSION['status'] = "Modification réussie";
            header("Location: listOffre.php");
      } else {
            $_SESSION['status'] = "Erreur";
            header("Location: listOffre.php");
      }
}