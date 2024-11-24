<?php
$target_url = "https://gtm-orn.viatorinc.com/orion/iframe/react/gtm/";

// Initialisation de cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Définir des en-têtes HTTP pour simuler un navigateur
$headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
    "Origin: https://attacker-site.com",  // Changez cette origine si nécessaire
    "Accept: application/json",
    "Accept-Language: en-US,en;q=0.9",
    "Connection: keep-alive"
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Exécution de la requête
$response = curl_exec($ch);

// Vérification des erreurs
if(curl_errno($ch)) {
    echo "Erreur cURL : " . curl_error($ch);
} else {
    // Vérification du statut de la réponse
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == 200) {
        echo "Réponse reçue : " . $response;
    } else {
        echo "Code HTTP : " . $http_code . " - La requête a échoué.";
    }
}

// Fermer la session cURL
curl_close($ch);
?>