<?php
// Initialize the session
session_start();

require_once "../../config.php";

if (isset($_POST["rating_data"])) {

      try {
            $compteIdsql = "SELECT id_c FROM compte WHERE login ='" . $_SESSION["username"] . "';";
            $stmt = $pdo->prepare($compteIdsql);
            $stmt->execute();
            $id_c = $stmt->fetch(PDO::FETCH_ASSOC)['id_c'];
      
            $data = array(
                  ':id_c' =>  $id_c,
                  ':id_entreprise' => $_POST["id_entreprise"],
                  ':note' => $_POST["rating_data"],
                  ':commentaire' => $_POST["user_review"],
            );
      
            $query = "INSERT INTO evaluation (id_c, id_entreprise, note, commentaire) VALUES (:id_c, :id_entreprise, :note, :commentaire)";
      
            $statement = $pdo->prepare($query);
      
            $statement->execute($data);
      
            echo "Ta note a été prise en compte, Merci";
      } catch(PDOException $e) {
            echo "Vous avez déjà noté cette entreprise, Vous serez redirigé vers la liste des entreprise, ";
            echo "Merci";
      }

}