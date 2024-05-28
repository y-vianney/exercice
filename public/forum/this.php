<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sujet n°<?= $_GET['ref'] ?></title>
    <?php include_once('../partials/link.php') ?>
</head>

<?php
include_once('../partials/authentication.php');

$user_id = $_SESSION['user_id'] ?? null;
?>

<body>
    <div class="main">
        <div class="sidebar">
            <?php include_once('../partials/sidebar.php') ?>
        </div>
        <div class="main-container" style="padding-top: 2rem">
            <?php
            if (!$user_id) {
                echo 'Vous ne pouvez pas avoir accès à cette page. Vérifiez vos accès.';
            } else {
            ?>
                <div id="subject-detail">
                </div>

                <div id="subject-response">
                </div>
            <?php } ?>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subjectId = <?= json_encode($_GET['ref']) ?>;

        function loadSubjectDetail() {
            fetch(`../../backend/forum.php?ref=${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        const subjectDetailDiv = document.getElementById('subject-detail');
                        subjectDetailDiv.innerHTML = `
                            <div class="header" style="display: flex; flex-direction: column; align-items: flex-start">
                                <span class="title">${data.title}</span>
                                <p>Par: ${data.user} (${data.user_email})</p>
                            </div>
                            <div class="description">
                                ${data.description}
                            </div>
                        `;

                        const subjectResponses = document.getElementById('subject-response');
                        subjectResponses.innerText = `${data.response ? data.response.length : 0} Réponse` + (data.response && data.response.length > 1 ? s : '');
                    } else {
                        document.getElementById('subject-detail').innerText = 'Sujet non trouvé.';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }

        loadSubjectDetail();
    });
</script>

</html>