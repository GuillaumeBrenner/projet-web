<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit;
}

// Définition des constantes pour le dossier de stockage des fichiers
define('LOGO_DIR', 'uploads/');

// Vérification de la soumission du formulaire
// Connexion à la base de données MySQL avec PDO
require_once "../../config.php";

// Récupération des données du formulaire
$nom = $_POST['nom'];
$nbr = $_POST['nbr'];
$villes = $_POST["villes"];
$secteurs = $_POST["secteurs"];
$validite = 1;

var_dump($_FILES);
var_dump($_POST);

// Récupération des informations du fichier LOGO soumis
$File = $_FILES['logo'];
$FileName = $File['name'];
$FileType = $File['type'];
$FileTmpName = $File['tmp_name'];
$FileError = $File['error'];
$FileSize = $File['size'];

// Vérification des types de fichiers autorisés
$allowedExtensions = array('jpg', 'jpeg', 'png');
$FileExtension = strtolower(pathinfo($FileName, PATHINFO_EXTENSION));

// Vérification du type de fichier et de la taille pour le CV
$maxFileSize = 10485760;

if (in_array($FileExtension, $allowedExtensions) && $FileSize <= $maxFileSize) {
    // Déplacement du fichier vers le dossier de stockage 
    $NewFileName = 'LOGO - ' . $nom . ' - ' . uniqid() . '.' . $FileExtension;
    $Destination = LOGO_DIR . $NewFileName;
    move_uploaded_file($FileTmpName, $Destination);
} else {
    if (!in_array($FileExtension, $allowedExtensions)) {
        $_SESSION['supp'] = "Le fichier du LOGO doit être au format : JPG, JPEG, PNG. ";
        header("Location: listEntreprise.php");
        exit();
    } elseif ($FileSize > $maxFileSize) {
        $_SESSION['supp'] = "La taille du fichier du LOGO est trop grande (ne doit pas dépasser 10Mo). ";
        header("Location: listEntreprise.php");
        exit();
    }
    $_SESSION['supp'] = "Une erreur est survenue lors du téléchargement du LOGO, Veuillez réessayer";
    header("Location: listEntreprise.php");
    exit();
}

// Insertion du chemin du fichier dans la base de données
$logo_name = $Destination;
try {
    // Insertion de l'entreprise dans la table entreprises
    $sql = "INSERT INTO entreprise ( nom, logo, validite, nombre_etudiant  ) VALUES (:nom, :logo , :validite , :nbr  )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':logo', $logo_name);
    $stmt->bindParam(':validite', $validite);
    $stmt->bindParam(':nbr', $nbr);
    $stmt->execute();
    // Récupération de l'identifiant de l'entreprise insérée
    $id_entreprise = $pdo->lastInsertId();

    // Insertion de la relation entre l'entreprise et ses secteurs dans la table avoir
    foreach ($secteurs as $secteur) {
        $sql = "INSERT INTO avoir ( id_entreprise, id_secteur ) VALUES (:id_entreprise, :id_secteur)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_secteur', $secteur);
        $stmt->bindParam(':id_entreprise', $id_entreprise);
        $stmt->execute();
    }

    // Insertion de la relation entre l'entreprise et ses localités dans la table site
    foreach ($villes as $ville) {
        $sql = "INSERT INTO site ( id_ville, id_entreprise ) VALUES (:id_ville, :id_entreprise)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_ville", $ville);
        $stmt->bindParam(":id_entreprise", $id_entreprise);
        $stmt->execute();
    }
    // Message de réussite
    $_SESSION['status'] = "Entreprise créée avec succès.";
    header("Location: listEntreprise.php");
    exit();
} catch (PDOException) {
    $_SESSION['supp'] = "Une erreur est survenue, Veuillez réessayer";
    header("Location: listEntreprise.php");
    exit();
}