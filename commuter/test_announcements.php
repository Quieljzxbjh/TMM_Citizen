<!DOCTYPE html>
<html>
<head>
    <title>Test Announcements API</title>
</head>
<body>
    <h1>Testing Announcements API</h1>
    <div id="result"></div>
    
    <script>
        fetch('api/announcements.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            })
            .catch(error => {
                document.getElementById('result').innerHTML = 'Error: ' + error;
            });
    </script>
</body>
</html>