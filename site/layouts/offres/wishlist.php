<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
      header("Location: ../../login.php");
      exit;
}

require_once "../../config.php";

var_dump($_POST);
echo $_SESSION["username"];

$sql = "SELECT id_c FROM compte WHERE login ='" . $_SESSION["username"] ."';" ;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$id_c = $stmt->fetch(PDO::FETCH_ASSOC)['id_c'];

echo $id_c;

$req = $pdo->prepare("INSERT INTO wishlist ( id_c , id_offre ) VALUES ( :id_c , :id_offre )");
$req->bindParam(":id_c", $id_c);
$req->bindParam(":id_offre", $_POST['id_offre']);
$req->execute();

header("Location: listOffre.php");

?>