<?php
session_start();

require_once 'db.php';

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    handleNewSubject();
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['ref'])) {
        loadSubjectDetail($_GET['ref']);
    } else {
        loadSubjects();
    }
}

function handleNewSubject() {
    global $forum_db;

    $err = "";

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $tags = $_POST['tag'];
    $desc = $_POST['desc'];
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO subject (title, tags, description, user_id, created_at) VALUES (?, ?, ?, ?, ?)";
    $stmt_new_subject = mysqli_prepare($forum_db, $query);
    mysqli_stmt_bind_param($stmt_new_subject, "sssss", $title, $tags, $desc, $user_id, $created_at);

    if (mysqli_stmt_execute($stmt_new_subject)) {
        setcookie('message', 'Inscription réussie', time() + 5, '/');
        header('Location: ../public/forum/index.php');
        exit();
    } else {
        $err = "Une erreur est survenue.\nInformation : " . mysqli_error($forum_db);
    }

    mysqli_stmt_close($stmt_new_subject);

    mysqli_close($forum_db);

    setcookie('err', $err, time() + 5, '/');
    echo $err;
    exit();
}

function loadSubjects() {
    global $forum_db, $conn;

    $query_subjects = "SELECT * FROM subject";
    $stmt_subjects = mysqli_prepare($forum_db, $query_subjects);
    mysqli_stmt_execute($stmt_subjects);
    $result_subjects = mysqli_stmt_get_result($stmt_subjects);

    $data = array();
    if (mysqli_num_rows($result_subjects) > 0) {
        while ($row_subject = mysqli_fetch_assoc($result_subjects)) {
            // Récupérer l'utilisateur associé à chaque sujet
            $user_id = $row_subject['user_id'];
            $query_user = "SELECT identity, mail FROM utilisateur WHERE id = ?";
            $stmt_user = mysqli_prepare($conn, $query_user);
            mysqli_stmt_bind_param($stmt_user, "i", $user_id);
            mysqli_stmt_execute($stmt_user);
            $result_user = mysqli_stmt_get_result($stmt_user);
            $user_info = mysqli_fetch_assoc($result_user);

            // Ajouter les informations de l'utilisateur au sujet
            $row_subject['user'] = $user_info['identity'];
            $row_subject['user_email'] = $user_info['mail'];

            $data[] = $row_subject;
        }
    }

    // Retourner les données encodées en JSON
    echo json_encode($data);

    mysqli_stmt_close($stmt_subjects);
    mysqli_close($forum_db);
    mysqli_close($conn);
}

function loadSubjectDetail($subject_id) {
    global $forum_db, $conn;

    // Récupérer les détails du sujet
    $query = "
        SELECT s.*
        FROM subject s
        WHERE s.id = ?
    ";
    $stmt_subject = mysqli_prepare($forum_db, $query);
    mysqli_stmt_bind_param($stmt_subject, "i", $subject_id);
    mysqli_stmt_execute($stmt_subject);
    $result_subject = mysqli_stmt_get_result($stmt_subject);

    if ($row_subject = mysqli_fetch_assoc($result_subject)) {
        $user_id = $row_subject['user_id'];
        $query_user = "SELECT identity, mail FROM utilisateur WHERE id = ?";
        $stmt_user = mysqli_prepare($conn, $query_user);
        mysqli_stmt_bind_param($stmt_user, "i", $user_id);
        mysqli_stmt_execute($stmt_user);

        $result_user = mysqli_stmt_get_result($stmt_user);
        $user_info = mysqli_fetch_assoc($result_user);

        // Récupérer les réponses
        $query_res = "SELECT * FROM response WHERE sub_id = ?";
        $stmt_res = mysqli_prepare($forum_db, $query_res);
        mysqli_stmt_bind_param($stmt_res,"i",$row_subject['id']);
        mysqli_stmt_execute($stmt_res);

        $result_res = mysqli_stmt_get_result($stmt_res);
        $res_info = mysqli_fetch_assoc($result_res);

        // Ajouter les informations sur l'utilisateur et les réponses
        $row_subject['user'] = $user_info['identity'];
        $row_subject['user_email'] = $user_info['mail'];
        $row_subject['response'] = $res_info;

        echo json_encode($row_subject);
    } else {
        echo json_encode(null);
    }

    mysqli_stmt_close($stmt_subject);
    mysqli_close($forum_db);
    mysqli_close($conn);
}
