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
define('PROFIL_DIR', 'imgEtudiant/');

// Vérification de la soumission du formulaire
if (isset($_POST['insertEtudiant'])) {
  // Connexion à la base de données MySQL avec PDO
  require_once "../../config.php";

  // Récupération des données du formulaire
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $sexe = $_POST['sexe'];
  $mail = $_POST['mail'];
  $login = $_POST['login'];
  $mdp = $_POST['mdp'];
  $promotion = $_POST['promotion'];
  $ville = $_POST['ville'];
  $id_entreprise = "";
  $idtype = 3;
  $validite = 1;

  var_dump($_FILES);
  var_dump($_POST);

  // Récupération des informations du fichier PROFIL soumis
  $File = $_FILES['imgProfil'];
  $FileName = $File['name'];
  $FileType = $File['type'];
  $FileTmpName = $File['tmp_name'];
  $FileError = $File['error'];
  $FileSize = $File['size'];

  // Vérification des types de fichiers autorisés
  $allowedExtensions = array('jpg', 'jpeg', 'png');
  $FileExtension = strtolower(pathinfo($FileName, PATHINFO_EXTENSION));

  // Vérification du type de fichier et de la taille pour la photo
  $maxFileSize = 10485760;
  try {
    if (in_array($FileExtension, $allowedExtensions) && $FileSize <= $maxFileSize) {
      // Déplacement du fichier vers le dossier de stockage 
      $NewFileName = 'PRFIL - ' . $nom . ' - ' . uniqid() . '.' . $FileExtension;
      $Destination = UPLOAD_DIR . PROFIL_DIR . $NewFileName;
      move_uploaded_file($FileTmpName, $Destination);
    } else {
      if (!in_array($FileExtension, $allowedExtensions)) {
        $_SESSION['supp'] = "La photo de profil doit être au format : JPG, JPEG, PNG. ";
        header("Location: listComptes.php");
        exit();
      } elseif ($FileSize > $maxFileSize) {
        $_SESSION['supp'] = "La taille de la photo de profil est trop grande (ne doit pas dépasser 10Mo). ";
        header("Location: listComptes.php");
        exit();
      }
      $_SESSION['supp'] = "Une erreur est survenue lors du téléchargement du photo de profil, Veuillez réessayer";
      header("Location: listComptes.php");
      exit();
    }

    // Insertion du chemin du fichier dans la base de données
    $profil_name = $Destination;

    // Insertion de personne dans la table personne
    $sql = "INSERT INTO personne (Nom, Prenom, sexe, mail ) VALUES (:nom, :prenom, :sexe, :mail)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":prenom", $prenom);
    $stmt->bindParam(":sexe", $sexe);
    $stmt->bindParam(":mail", $mail);
    $stmt->execute();
    // Récupération de l'identifiant de la personne insérée
    $id_personne = $pdo->lastInsertId();

    // Insertion de compte dans la table compte
    $sql = "INSERT INTO compte (login, photo_profil, mdp, validite, id_personne, id_type) VALUES (:login, :photo_profil, :mdp, :validite, :id_personne, :id_type )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":login", $login);
    $stmt->bindParam(":mdp", $mdp);
    $stmt->bindParam(":photo_profil", $profil_name);
    $stmt->bindParam(":validite", $validite);
    $stmt->bindParam(":id_personne", $id_personne);
    $stmt->bindParam(":id_type", $idtype);
    $stmt->execute();
    // Récupération de l'identifiant de la personne insérée
    $id_compte = $pdo->lastInsertId();

    // Insertion de compte dans la table Centre
    $sql = "INSERT INTO centre (id_c, id_ville ) VALUES ( :id_c, :id_ville )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id_c", $id_compte);
    $stmt->bindParam(":id_ville", $ville);
    $stmt->execute();

    // Insertion de compte dans la table ETRE PROMO
    $sql = "INSERT INTO etre_promo (id_c, id_promotion ) VALUES ( :id_c, :id_promotion )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id_c", $id_compte);
    $stmt->bindParam(":id_promotion", $promotion);
    $stmt->execute();

    // Message de réussite
    $_SESSION['status'] = "Compte Etudiant créé avec succès.";
    header("Location: listComptes.php");
    exit();
  } catch (PDOException) {
    $_SESSION['supp'] = "Une erreur est survenue, Veuillez réessayer";
    header("Location: listComptes.php");
    exit();
  }
}