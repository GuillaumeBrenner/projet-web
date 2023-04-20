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

      // Vérification du type de fichier et de la taille pour le CV
      $maxFileSize = 10485760;

      if (in_array($cvFileExtension, $allowedExtensions) && $cvFileSize <= $maxFileSize) {
            // Déplacement du fichier vers le dossier de stockage 
            $cvNewFileName = 'CV - ' .  $_SESSION["username"] . ' - ' . uniqid() . '.' . $cvFileExtension;
            $cvDestination = CV_DIR . $cvNewFileName;
            move_uploaded_file($cvFileTmpName, $cvDestination);
      } else {
            if (!in_array($cvFileExtension, $allowedExtensions)) {
                  $_SESSION['supp'] = "Le fichier du CV doit être au format : PDF, JPG, JPEG, PNG. ";
                  header("Location: listOffre.php");
                  exit();
            } elseif ($cvFileSize > $maxFileSize) {
                  $_SESSION['supp'] = "La taille du fichier du CV est trop grande (ne doit pas dépasser 10Mo). ";
                  header("Location: listOffre.php");
                  exit();
            }
            $_SESSION['supp'] = "Une erreur est survenue lors du téléchargement des fichiers, Veuillez réessayer.(CV)";
            header("Location: listOffre.php");
            exit();
      }

      // Vérification du type de fichier et de la taille pour la LDM
      if (in_array($lettreFileExtension, $allowedExtensions) && $lettreFileSize <= $maxFileSize) {
            // Déplacement du fichier vers le dossier de stockage 
            $lettreNewFileName = 'LETTRE - ' . $_SESSION["username"] . ' - ' . uniqid() . '.' . $lettreFileExtension;
            $lettreDestination = LDM_DIR . $lettreNewFileName;
            move_uploaded_file($lettreFileTmpName, $lettreDestination);
      } else {
            if (!in_array($lettreFileExtension, $allowedExtensions)) {
                  $_SESSION['supp'] = "Le fichier de la lettre doit être au format : PDF, JPG, JPEG, PNG.";
                  header("Location: listOffre.php");
                  exit();
            }
            if ($lettreFileSize > $maxFileSize) {
                  $_SESSION['supp'] = "La taille du fichier de la Lettre est trop grande (ne doit pas dépasser 10Mo). ";
                  header("Location: listOffre.php");
                  exit();
            }
            $_SESSION['supp'] = "Une erreur est survenue lors du téléchargement des fichiers, Veuillez réessayer.(Lettre)";
            header("Location: listOffre.php");
            exit();
      }

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