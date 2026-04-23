<!DOCTYPE html>
<html>
<head>
    <title>Test API</title>
</head>
<body>

    <h1>Test accès API</h1>
    <button onclick="callApi()">Tester l'API</button>
    <pre id="result" style="margin-top:20px; background:#eee; padding:10px;"></pre>

    <script>

        function callApi() {
            fetch('/api/films/1/locations', {
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzc2OTQ4OTI1LCJleHAiOjE3NzY5NTI1MjUsIm5iZiI6MTc3Njk0ODkyNSwianRpIjoibFlLTTdJN2NRMzJ6a3VpTiIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.iev_F-sR6EGZmqdTHv_Z4KPUDa0xyiWd7aBB-FKztQo'
                }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('result').textContent =
                    JSON.stringify(data, null, 2);
            })
            .catch(err => {
                document.getElementById('result').textContent =
                    "Erreur : " + err;
            });
        }
    </script>

</body>
</html>