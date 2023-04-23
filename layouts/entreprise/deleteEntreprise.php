<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config.php";

try {
    $id_entreprise = $_POST['id_entreprise'];

    $sql = "UPDATE entreprise SET validite = 0 WHERE id_entreprise = :id_entreprise ";
    // Préparation et exécution de la requête de suppression
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_entreprise', $id_entreprise);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Entreprise supprimée avec succès";
        header("Location: listEntreprise.php");
    } else {
        $_SESSION['supp'] = "Erreur de suppression";
        header("Location: listEntreprise.php");
    }
} catch (PDOException) {
    $_SESSION['supp'] = "Erreur de suppression, Veuillez réessayer";
    header("Location: listEntreprise.php");
}
