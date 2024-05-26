<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirection</title>
    <style>
        .message {
            font-size: 24px;
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            height: 100vh;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
    </style>
    <script>
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 5000);
    </script>
</head>
<body>
    <div class="message">
        Inscription réussie. Vous serez redirigé vers la page de connexion dans 5 secondes.
    </div>
</body>
</html>