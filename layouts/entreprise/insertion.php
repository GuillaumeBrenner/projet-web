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
// Définition de la constante pour le dossier de base
define('BASE_URL', 'http://localhost/projet-web/layouts/entreprise/uploads/');

// Vérification de la soumission du formulaire
if (isset($_FILES['logo'])) {
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

    //if ($FileSize == 0) {
    //  $photo_profil = '../../upload/profile_pics/default.png';
    //}

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
    $logo_name = BASE_URL . $Destination;
    //creation entreprise
    $sql = "INSERT INTO entreprise ( nom, logo, validite, nombre_etudiant  ) VALUES (:nom, :logo , :validite , :nbr  )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':logo', $logo_name);
    $stmt->bindParam(':validite', $validite);
    $stmt->bindParam(':nbr', $nbr);

    try {
        $stmt->execute();
        $id_entreprise_created = $pdo->lastInsertId();
        var_dump($id_entreprise_created);
        // Message de réussite
        $_SESSION['status'] = "Les fichiers ont été téléchargé avec succès.";
        header("Location: listEntreprise.php");
        exit();
    } catch (PDOException) {
        $_SESSION['supp'] = "Une erreur est survenue, Veuillez réessayer";
        header("Location: listEntreprise.php");
        exit();
    }


    // Parcourir les options sélectionnées et les stocker dans la base de données
    foreach ($secteurs as $secteur) {
        $query = "INSERT INTO avoir ( id_secteur, id_entreprise ) VALUES (:id_secteur, :id_entreprise )";
        $statemenet = $pdo->prepare($query);
        $statemenet->bindParam(':id_secteur', $secteur);
        $statemenet->bindParam(':id_entreprise', $id_entreprise_created);
        $statemenet->execute();
    }

    // ajout ville
    for ($i = 0; $i < count($ville); $i++) {
        $vil = substr($Ville[$i], 0, -7);
        $id_ville = $pdo->prepare("SELECT id_ville  FROM ville WHERE ville = :ville");
        $id_ville->bindParam(":ville", $vil);
        $id_ville->execute();
        $id_ville = $id_ville->fetch();
        $id_ville = $id_ville['id_ville'];

        $ville_creation = $pdo->prepare("INSERT INTO site ( id_ville, id_entreprise ) VALUES (:id_ville, :id_entreprise )");
        $ville_creation->bindParam(":id_ville", $id_ville);
        $ville_creation->bindParam(":id_entreprise", $id_entreprise_created);
        $ville_creation->execute();
    }
    $pdo = null;
}