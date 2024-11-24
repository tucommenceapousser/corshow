<?php
// Fonction pour extraire les styles présents dans les balises <style>
function extractInlineStyles($filePath) {
    if (!file_exists($filePath)) {
        die("Le fichier '$filePath' n'existe pas.\n");
    }
    $content = file_get_contents($filePath);
    $pattern = '/<style[^>]*>(.*?)<\/style>/is';
    preg_match_all($pattern, $content, $matches);
    return $matches[1];
}

// Récupération du fichier depuis l'URL
$fileName = $_GET['file'] ?? null;
if (!$fileName) {
    die("Veuillez spécifier un fichier dans l'URL, par exemple : ?file=index.php\n");
}

// Extraction des styles
$inlineStyles = extractInlineStyles($fileName);

// Affichage des résultats
if (!empty($inlineStyles)) {
    echo "<h2>Styles CSS trouvés dans '$fileName' :</h2>";
    foreach ($inlineStyles as $index => $styleContent) {
        echo "<pre><strong>Bloc de styles " . ($index + 1) . " :</strong>\n" . htmlspecialchars(trim($styleContent)) . "</pre>";
    }
} else {
    echo "<p>Aucun style CSS trouvé dans '$fileName'.</p>";
}
?>