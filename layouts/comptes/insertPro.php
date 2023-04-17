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
$first_Name = $_POST["nom"];
$last_Name = $_POST["prenom"];
$Sexe = $_POST["sexe"];


//set the variable for the compte we want to create
$motdepasse = $_POST["mdp"];
$login = $_POST["login"];
$id_entreprise= $_POST["entreprise"];


//set the variable for the type we want to create
$idtype= 2;



// Here we create a variable that calls the prepare() method of the database object
// The SQL query you want to run is entered as the parameter, and placeholders are written like this :placeholder_name
$person_creation= $pdo->prepare("INSERT INTO personne (Nom, Prenom, sexe ) VALUES (:first_name, :last_name, :sexe)");

// Now we tell the script which variable each placeholder actually refers to using the bindParam() method
// First parameter is the placeholder in the statement above - the second parameter is a variable that it should refer to
$person_creation->bindParam(":first_name", $first_Name);
$person_creation->bindParam(":last_name", $last_Name);
$person_creation->bindParam(":sexe", $Sexe);


//recuperating personne id
if($person_creation->execute()){
    $idpersonne_created=$pdo->lastInsertId();
}
$validite = 1;


$id_ent = $pdo->prepare("SELECT id_entreprise FROM entreprise WHERE nom = :nom");
$id_ent->bindParam(":nom", $id_entreprise);
$id_ent->execute();
$id_entreprise = $id_ent->fetch()['id_entreprise'];

//creation compte etudiant
echo 'zjdfgb';
echo $id_entreprise;

$compte_pilote_creation=$pdo->prepare("INSERT INTO compte (login, photo_profil, mdp, validite, id_personne, id_type , id_entreprise) VALUES (:login, :photo_profil, :mdp, :validite, :id_personne, :id_type , :id_entreprise )");
$compte_pilote_creation->bindParam(":login", $login);
$compte_pilote_creation->bindParam(":photo_profil", $photo_profil);
$compte_pilote_creation->bindParam(":mdp", $motdepasse);
$compte_pilote_creation->bindParam(":validite", $validite);
$compte_pilote_creation->bindParam(":id_personne", $idpersonne_created);
$compte_pilote_creation->bindParam(":id_type", $idtype);
$compte_pilote_creation->bindParam(":id_entreprise", $id_entreprise);
$compte_pilote_creation->execute()

?>