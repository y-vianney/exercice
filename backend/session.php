<?php
require_once 'db.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identity = "";
    $identity .= $_POST['nom'] ? $_POST['nom'] : "";
    $identity .= $_POST['prenoms'] ?
        (
            $identity == "" ?
            $_POST['prenoms'] :
            " " . $_POST['prenoms']
        ) :
        "";
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

    $response['data'] = [
        'nom' => $_POST['nom'],
        'prenoms' => $_POST['prenoms'],
        'email' => $email,
    ];

    define($passwordRegex, "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$/");

    // Vérifiez que tous les champs sont remplis
    if (empty($email) || empty($password)) {
        $response['message'] = "Tous les champs doivent être remplis.";
    } else if (!preg_match($passwordRegex, $password)) {
        $response['message'] = "Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, une minuscule et un chiffre.";
    } else if ($password !== $confirm_password) {
        $response['message'] = "Les mots de passe ne correspondent pas.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Veuillez entrer une adresse email valide.";
    } else {
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Générer la date d'inscription
        $created_at = date("Y-m-d H:i:s");

        // Préparer la requête SQL
        $id = "";
        $sql = "INSERT INTO utilisateur (id, identity, mail, password, auth, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $id, $identity, $email, $hashed_password, $date);

        // Exécuter la requête
        if (mysqli_stmt_execute($stmt)) {
            echo "Inscription réussie !";
            exit();
        } else {
            $response['message'] = "Une erreur est survenue.\nInformation : " . mysqli_error($conn);
        }

        // Fermer la déclaration et la connexion
        mysqli_stmt_close($stmt);
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);

    // Url de redirection
    $res_query = http_build_query([
        'error_message' => $response['message'],
        'nom' => $response['data']['nom'],
        'prenoms' => $response['data']['prenoms'],
        'email' => $response['data']['email'],
        'password' => $password,
    ]);

    // Renvoyer la reponse
    header("Location: ../pages/index.php?" . $res_query);
    exit();
}
