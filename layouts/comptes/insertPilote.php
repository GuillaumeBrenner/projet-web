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

//set the variable for the ville of the person
$Ville = substr($_POST["ville"] , 0 , -7);



//set the variable for the compte we want to create
$motdepasse = $_POST["mdp"];
$login = $_POST["login"];
$id_entreprise="";


//set the variable for the type we want to create
$idtype= 4;


//the photo of profil part of the projet


$promo = $_POST["promo"];



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

$villeid = $pdo->prepare("SELECT id_ville FROM ville WHERE ville = :ville");
$villeid->bindParam(":ville", $Ville);
$villeid->execute();
$idville_seleced = $villeid->fetch(PDO::FETCH_ASSOC)['id_ville'];

$validite = 1;

//creation compte etudiant

$compte_pilote_creation=$pdo->prepare("INSERT INTO compte (login, photo_profil, mdp, validite, id_personne, id_type) VALUES (:login, :photo_profil, :mdp, :validite, :id_personne, :id_type )");
$compte_pilote_creation->bindParam(":login", $login);
$compte_pilote_creation->bindParam(":photo_profil", $photo_profil);
$compte_pilote_creation->bindParam(":mdp", $motdepasse);
$compte_pilote_creation->bindParam(":validite", $validite);
$compte_pilote_creation->bindParam(":id_personne", $idpersonne_created);
$compte_pilote_creation->bindParam(":id_type", $idtype);

if($compte_pilote_creation->execute()){
  $id_pilote_created=$pdo->lastInsertId();}



//relying compte w his locality whit the table "centre"
$compte_centre_creation=$pdo->prepare("INSERT INTO centre (id_c, id_ville ) VALUES ( :id_c, :id_ville )");
$compte_centre_creation->bindParam(":id_c", $id_pilote_created);
$compte_centre_creation->bindParam(":id_ville", $idville_seleced);
$compte_centre_creation->execute();

for ($i=0; $i < count($promo); $i++) {
    $promo_creation=$pdo->prepare("INSERT INTO etre_promo (id_c, id_promotion ) VALUES ( :id_c, :id_promo )");
    $promo_creation->bindParam(":id_c", $id_pilote_created);
    $promo_creation->bindParam(":id_promo", $promo[$i]);
    $promo_creation->execute();
}

header("Location: listComptes.php")

?>