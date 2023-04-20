<?php
// Include the database config file 
require_once "../../config.php";

if (!empty($_POST["id_entreprise"])) {

      // Fetch site data based on the specific country 
      $query = "SELECT * FROM site JOIN ville ON site.id_ville = ville.id_ville WHERE site.id_entreprise = " . $_POST['id_entreprise'] . " ";
      $result = $pdo->query($query);

      // Generate HTML of site options list 
      if ($result->rowCount() > 0) {
            echo '<option value="">Selectionner le site</option>';
            while ($row = $result->fetch()) {                  
                  echo '<option value="' . $row['id_site'] . '">' . $row['ville'] . '</option>';
            }
      } else {
            echo '<option value="">Aucun site n est lié à cette entreprise</option>';
      }
}