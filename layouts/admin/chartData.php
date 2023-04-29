<?php

require_once "../../config.php";

header('Content-Type: application/json');
$sql = $pdo->prepare("SELECT id_entreprise, nom, nombre_etudiant FROM entreprise ORDER BY id_entreprise");
$stmt->execute();
// Exécuter la requête SQL
$stmt = $pdo->query($sql);

// Récupérer les données de la requête
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Créer un tableau pour stocker les données du graphique
$chartData = [];

// Boucler à travers les données et ajouter chaque entreprise avec son nombre d'employés au tableau
foreach ($data as $row) {
  $chartData[] = [
    'x' => $row['nom'],
    'y' => $row['nombre_etudiant'],
  ];
}

// Encoder les données en JSON pour les passer à jsChart
$chartDataJSON = json_encode($chartData);