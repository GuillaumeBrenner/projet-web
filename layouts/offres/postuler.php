<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

// Définition des constantes pour le dossier de stockage des fichiers
define('UPLOAD_DIR', 'uploads/');
define('CV_DIR', UPLOAD_DIR . 'cv/');
define('LDM_DIR', UPLOAD_DIR . 'ldm/');
// Définition de la constante pour le dossier de base
define('BASE_URL', 'http://localhost/projet-web/layouts/offres/uploads/');

// Vérification de la soumission du formulaire
if (isset($_FILES['cv']) && isset($_FILES['ldm'])) {
      // Connexion à la base de données MySQL avec PDO
      require_once "../../config.php";

      // Récupération de l'id du compte 
      $compteIdSql = "SELECT id_c FROM compte WHERE login ='" . $_SESSION["username"] . "';";
      $statement = $pdo->prepare($compteIdSql);
      $statement->execute();
      $id_c = $statement->fetch(PDO::FETCH_ASSOC)['id_c'];
      // Récupération de l'id de l'offre 
      $id_offre = $_POST['id_offre'];

      // Récupération des informations du fichier CV soumis
      $cvFile = $_FILES['cv'];
      $cvFileName = $cvFile['name'];
      $cvFileType = $cvFile['type'];
      $cvFileTmpName = $cvFile['tmp_name'];
      $cvFileError = $cvFile['error'];
      $cvFileSize = $cvFile['size'];

      // Récupération des informations du fichier lettre soumis
      $lettreFile = $_FILES['ldm'];
      $lettreFileName = $lettreFile['name'];
      $lettreFileType = $lettreFile['type'];
      $lettreFileTmpName = $lettreFile['tmp_name'];
      $lettreFileError = $lettreFile['error'];
      $lettreFileSize = $lettreFile['size'];

      // Vérification des types de fichiers autorisés
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
      $cvFileExtension = strtolower(pathinfo($cvFileName, PATHINFO_EXTENSION));
      $lettreFileExtension = strtolower(pathinfo($lettreFileName, PATHINFO_EXTENSION));

      if (!in_array($cvFileExtension, $allowedExtensions) || !in_array($lettreFileExtension, $allowedExtensions)) {
            $_SESSION['supp'] = "Les fichiers doivent être au format : PDF, JPG, JPEG, PNG.";
            header("Location: listOffre.php");
            exit();
      }

      // Vérification de la taille des fichiers;
      $maxSize = 10485760; // 10485760 Octets = 10 Mo
      if ($cvFileSize > $maxSize || $lettreFileSize > $maxSize) {
            $_SESSION['supp'] = "la taille du fichier est trop grande (Télécharger un fichier de moins de 10Mo).";
            header("Location: listOffre.php");
            exit();
      }

      // Déplacement du fichier vers le dossier de stockage 
      $cvNewFileName = 'CV - ' .  $_SESSION["username"] . ' - ' . uniqid() . '.' . $cvFileExtension;
      $cvDestination = CV_DIR . $cvNewFileName;

      $lettreNewFileName = 'LETTRE - ' . $_SESSION["username"] . ' - ' . uniqid() . '.' . $lettreFileExtension;
      $lettreDestination = LDM_DIR . $lettreNewFileName;

      if (move_uploaded_file($cvFileTmpName, $cvDestination) && move_uploaded_file($lettreFileTmpName, $lettreDestination)) {
            // Insertion du chemin du fichier dans la base de données
            $cv_name = BASE_URL . $cvDestination;
            $ldm_name = BASE_URL . $lettreDestination;

            $sql = "INSERT INTO postule (id_c, id_offre, cv_name, ldm_name) VALUES (:id_c, :id_offre, :cv_name, :ldm_name)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_c', $id_c);
            $stmt->bindParam(':id_offre', $id_offre);
            $stmt->bindParam(':cv_name', $cv_name);
            $stmt->bindParam(':ldm_name', $ldm_name);

            if ($stmt->execute()) {
                  // Message de réussite
                  $_SESSION['status'] = "Les fichiers ont été téléchargé avec succès.";
                  header("Location: listOffre.php");
                  exit();
            }
      }
      // Message si ça existe déja
      else {
            $_SESSION['supp'] = "Une erreur est survenue lors du téléchargement des fichiers, Veuillez réessayer.";
            header("Location: listOffre.php");
            exit();
      }
} else {
      $_SESSION['supp'] = "Vous n'avez télécharger aucun fichier, Veuillez réessayer";
      header("Location: listOffre.php");
      exit();
}