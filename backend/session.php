<?php
session_start();

require_once 'db.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        handleLogin();
    } else {
        handleRegistration();
    }
}

function handleLogin() {
    global $conn;

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_check_login = "SELECT * FROM utilisateur WHERE mail = ?";
    $stmt_check_login = mysqli_prepare($conn, $sql_check_login);
    mysqli_stmt_bind_param($stmt_check_login, "s", $email);
    mysqli_stmt_execute($stmt_check_login);
    $result_check_login = mysqli_stmt_get_result($stmt_check_login);

    if (mysqli_num_rows($result_check_login) == 1) {
        $row = mysqli_fetch_assoc($result_check_login);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: ../public/pages/home.php");
            exit();
        } else {
            $err = "Mot de passe incorrect.";
        }
    } else {
        $err = "Adresse email incorrecte.";
    }

    mysqli_close($conn);

    $query = http_build_query([
        'err' => $err,
        'email' => $email
    ]);
    header("Location: ../public/pages/index.php?" . $query);
    exit();
}


function handleRegistration() {
    global $conn, $response;

    $identity = $_POST['nom'] . ' ' . $_POST['prenoms'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

    $sql_check_email = "SELECT * FROM utilisateur WHERE mail = ?";
    $stmt_check_email = mysqli_prepare($conn, $sql_check_email);
    mysqli_stmt_bind_param($stmt_check_email, "s", $email);
    mysqli_stmt_execute($stmt_check_email);
    $result_check_email = mysqli_stmt_get_result($stmt_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        $response['message'] = "Cet email est déjà utilisé.";
    } else {
        $response['data'] = [
            'nom' => $_POST['nom'],
            'prenoms' => $_POST['prenoms'],
            'email' => $email,
        ];

        $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,}$/";

        if (empty($email) || empty($password)) {
            $response['message'] = "Tous les champs doivent être remplis.";
        } else if (!preg_match($passwordRegex, $password)) {
            $response['message'] = "Le mot de passe doit contenir au moins 6 caractères, incluant une majuscule, une minuscule et un chiffre.";
        } else if ($password !== $confirm_password) {
            $response['message'] = "Les mots de passe ne correspondent pas.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = "Veuillez entrer une adresse email valide.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $created_at = date("Y-m-d H:i:s");
            $sql = "INSERT INTO utilisateur (identity, mail, password, created_at) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $identity, $email, $hashed_password, $created_at);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../public/pages/success.php");
                exit();
            } else {
                $response['message'] = "Une erreur est survenue.\nInformation : " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);

    $res_query = http_build_query([
        'err' => $response['message'],
        'nom' => $response['data']['nom'],
        'prenoms' => $response['data']['prenoms'],
        'email' => $response['data']['email'],
    ]);

    header("Location: ../public/pages/index.php?" . $res_query);
    exit();
}
