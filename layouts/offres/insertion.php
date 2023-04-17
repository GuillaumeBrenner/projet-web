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
      $ville = $_POST["ville"];

      //recupération de l'id du site 
      $Sitereq = "SELECT id_site FROM 
      site s
      INNER JOIN entreprise e ON e.id_entreprise = s.id_entreprise
      INNER JOIN ville v ON v.id_ville = s.id_ville
      WHERE e.nom = '".$entreprise."' and v.ville = '".$ville."' ";

      $reponse = $pdo->query($Sitereq);
      $site = $reponse->fetch();
      var_dump($site);

      $sql = "INSERT INTO offre(Titre, descrip , Durée, Date_post, nombre_places, Remuneration, valide, id_site) VALUES('$titre','$description','$duree', '$date_post', '$nombre_places', '$remuneration', '$validite', '{$site['id_site']}')";
       
      $stmt = $pdo->exec($sql);
      
      if ($stmt) {
            $_SESSION['status'] = "Offre ajoutée";
            header("Location: listOffre.php");
      } else {
            $_SESSION['status'] = "Erreur";
            header("Location: listOffre.php");
      }
}