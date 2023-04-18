<?php

// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
require_once "../../config.php";

var_dump($_POST);
var_dump($_FILES);

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

// Set the variables for the person we want to add to the database
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$sexe = $_POST["sexe"];

//set the variable for the ville of the person
$Ville = substr($_POST["ville"] , 0 , -7);

//set the variable for the compte we want to create
$login = $_POST["login"];
$mdp = $_POST["mdp"];
$id_entreprise="";

//set the variable for the type we want to create
$idtype= 3;

//the photo of profil part of the projet




// Here we create a variable that calls the prepare() method of the database object
// The SQL query you want to run is entered as the parameter, and placeholders are written like this :placeholder_name
$person_creation= $pdo->prepare("INSERT INTO personne (Nom, Prenom, sexe ) VALUES (:nom, :prenom, :sexe)");

// Now we tell the script which variable each placeholder actually refers to using the bindParam() method
// First parameter is the placeholder in the statement above - the second parameter is a variable that it should refer to
$person_creation->bindParam(":nom", $nom);
$person_creation->bindParam(":prenom", $prenom);
$person_creation->bindParam(":sexe", $sexe);

//recuperating personne id
if($person_creation->execute())
{
    $idPersonne_created = $pdo->lastInsertId();
}

$villeid = $pdo->prepare("SELECT id_ville FROM ville WHERE ville = :ville");
$villeid->bindParam(":ville", $Ville);
$villeid->execute();
$idville_selected = $villeid->fetch(PDO::FETCH_ASSOC)['id_ville'];

$validite = 1;

//creation compte etudiant

$compte_etudiant_creation = $pdo->prepare("INSERT INTO compte (login, photo_profil, mdp, validite, id_personne, id_type) VALUES (:login, :photo_profil, :mdp, :validite, :id_personne, :id_type )");
$compte_etudiant_creation->bindParam(":login", $login);
$compte_etudiant_creation->bindParam(":photo_profil", $photo_profil);
$compte_etudiant_creation->bindParam(":mdp", $motdepasse);
$compte_etudiant_creation->bindParam(":validite", $validite);
$compte_etudiant_creation->bindParam(":id_personne", $idpersonne_created);
$compte_etudiant_creation->bindParam(":id_type", $idtype);

if($compte_etudiant_creation->execute())
{
  $idEtudiant_created = $pdo->lastInsertId();
}

//relying compte w his locality whit the table "centre"
$compte_centre_creation=$pdo->prepare("INSERT INTO centre (id_c, id_ville ) VALUES ( :id_c, :id_ville )");
$compte_centre_creation->bindParam(":id_c", $idEtudiant_created);
$compte_centre_creation->bindParam(":id_ville", $idville_selected);
$compte_centre_creation->execute();

header("Location : listComptes.php")

?>