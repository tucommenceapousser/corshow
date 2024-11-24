<?php
// Création de la base de données
$db = new SQLite3('database.db');

// Création de la table "users"
$db->exec("DROP TABLE IF EXISTS users");
$db->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT, password TEXT)");

// Insertion de données fictives
$db->exec("INSERT INTO users (username, password) VALUES ('admin', 'trhacknon')");
$db->exec("INSERT INTO users (username, password) VALUES ('user1', 'trkntrkn')");
$db->exec("INSERT INTO users (username, password) VALUES ('user2', 'trkn')");

echo "Base de données initialisée avec succès.";