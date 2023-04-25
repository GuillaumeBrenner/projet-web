<?php

require_once "../../config.php";
// Vérifier si le formulaire a été soumis
if (isset($_POST['id_c']) && isset($_POST['id_type'])) {
    
      // Mettre à jour l'id_type de l'utilisateur dans la base de données
      $stmt = $pdo->prepare('UPDATE compte SET id_type = :id_type WHERE id_c = :id_c');
      
      $stmt->bindParam(':id_type', $_POST['id_type'], PDO::PARAM_INT);
      $stmt->bindParam(':id_c', $_POST['id_c'], PDO::PARAM_INT);
      $stmt->execute();
    
      // Rediriger vers la page d'accueil
      header('Location: listUsers.php');
      exit;
}