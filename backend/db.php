<?php
    // Connect to database
    $conn = mysqli_connect('localhost', 'root', 'root', 'daw_db', 8889);
    $forum_db = mysqli_connect('localhost', 'root', 'root', 'daw_forum_db', 8889);

    // Check connection
    if (!$conn) {
        die('La connexion à la base de donnée a échouée: ' . mysqli_connect_error());
    }

    if (!$forum_db) {
        die('La connexion à la base de données du forum a échouée'. mysqli_connect_error());
    }

    // echo 'Connected successfully';
