<?php
// Connexion à la base de données
$db = new SQLite3('database.db');

// Récupération du paramètre vulnérable
$id = $_GET['id'] ?? '';

// Construction de la requête SQL vulnérable
$query = "SELECT * FROM users WHERE id = '$id'";

// Exécution de la requête
$result = $db->query($query);

// Affichage des résultats
$output = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $output[] = $row;
}

// Conversion des résultats en JSON
echo json_encode($output);