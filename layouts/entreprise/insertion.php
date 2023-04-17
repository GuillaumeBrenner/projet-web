<?php

// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
require_once "../../config.php";

var_dump($_FILES);
var_dump($_POST);
// Set the variablesfor the entreprise
$Nom_entreprise = $_POST["Nom_entreprise"];
$Secteur_dactivité = $_POST["secteur"];
$Ville = $_POST["ville"];
$validite = 1;
$Nombre_etudiants = $_POST["Nombre_etudiants"];

$tmpName = $_FILES['profile_img']['tmp_name'];
$name = $_FILES['profile_img']['name'];
$size = $_FILES['profile_img']['size'];
$error = $_FILES['profile_img']['error'];
$tabExtension = explode('.', $name);
$extension = strtolower(end($tabExtension));
$uniqueName = uniqid('', true);
$file = $uniqueName.".".$extension;
move_uploaded_file($tmpName, '../../upload/profile_pics/'.$file);

$photo_profil = '../../upload/profile_pics/'.$file;

if ($size == 0) {
    $photo_profil = '../../upload/profile_pics/default.png';
}


//creation entreprise
$entreprise_creation= $pdo->prepare("INSERT INTO entreprise ( nom, photo_profil, validite, nombre_etudiant  ) VALUES (:nom, :photo_profil , :validite , :nombre_etudiant  )");
$entreprise_creation->bindParam(":nom", $Nom_entreprise);
$entreprise_creation->bindParam(":photo_profil", $photo_profil);
$entreprise_creation->bindParam(":validite", $validite);
$entreprise_creation->bindParam(":nombre_etudiant", $Nombre_etudiants);
$entreprise_creation->execute();
$id_entreprise_created = $pdo->lastInsertId(); 

// ajout secteur d'activité

for ($i=0; $i < count($Secteur_dactivité) ; $i++) { 
    $id_secteur = $pdo->prepare("SELECT id_secteur  FROM secteur_activité WHERE secteur = :secteur");
    $id_secteur->bindParam(":secteur", $Secteur_dactivité[$i]);
    $id_secteur->execute();
    $id_secteur = $id_secteur->fetch();
    $id_secteur = $id_secteur['id_secteur'];

    $secteur_creation= $pdo->prepare("INSERT INTO avoir ( id_secteur, id_entreprise ) VALUES (:id_secteur, :id_entreprise )");
    $secteur_creation->bindParam(":id_secteur", $id_secteur);
    $secteur_creation->bindParam(":id_entreprise", $id_entreprise_created);
    $secteur_creation->execute();
}

// ajout ville

for ($i=0; $i < count($Ville) ; $i++) { 
    $vil = substr($Ville[$i] , 0 , -7);
    $id_ville = $pdo->prepare("SELECT id_ville  FROM ville WHERE ville = :ville");
    $id_ville->bindParam(":ville", $vil);
    $id_ville->execute();
    $id_ville = $id_ville->fetch();
    $id_ville = $id_ville['id_ville'];
    
    $ville_creation= $pdo->prepare("INSERT INTO site ( id_ville, id_entreprise ) VALUES (:id_ville, :id_entreprise )");
    $ville_creation->bindParam(":id_ville", $id_ville);
    $ville_creation->bindParam(":id_entreprise", $id_entreprise_created);
    $ville_creation->execute();
}


?>