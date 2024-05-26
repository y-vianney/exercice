<?php
    // Connect to database
    $conn = mysqli_connect('localhost', 'root', 'root', 'daw_db', 8889);

    // Check connection
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // echo 'Connected successfully';
?>