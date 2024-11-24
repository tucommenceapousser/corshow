<?php
// Fonction pour extraire les styles présents dans les balises <style>
function extractInlineStyles($filePath) {
    // Vérifie si le fichier existe
    if (!file_exists($filePath)) {
        die("Le fichier '$filePath' n'existe pas.\n");
    }

    // Lit le contenu du fichier
    $content = file_get_contents($filePath);

    // Expression régulière pour capturer le contenu des balises <style>
    $pattern = '/<style[^>]*>(.*?)<\/style>/is';

    // Recherche des correspondances
    preg_match_all($pattern, $content, $matches);

    // Retourne le contenu des balises <style>
    return $matches[1];
}

// Demande du nom du fichier à analyser
echo "Entrez le nom du fichier PHP (ex: exemple.php) : ";
$handle = fopen("php://stdin", "r");
$fileName = trim(fgets($handle));
fclose($handle);

// Extraction des styles
$inlineStyles = extractInlineStyles($fileName);

// Affichage des résultats
if (!empty($inlineStyles)) {
    echo "Styles CSS trouvés dans '$fileName' :\n";
    foreach ($inlineStyles as $index => $styleContent) {
        echo "\n--- Bloc de styles " . ($index + 1) . " ---\n";
        echo trim($styleContent) . "\n";
    }
} else {
    echo "Aucun style CSS trouvé dans '$fileName'.\n";
}
?>