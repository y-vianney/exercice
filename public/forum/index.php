<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('../partials/link.php') ?>
    <title>Forum</title>
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
        <div class="main-container">
            <?php
            if (!$user_id) {
                echo 'Vous ne pouvez pas avoir accès au forum. Vérifiez vos accès.';
            } else {
            ?>
                <div class="header">
                    <span class="title">Forum</span>
                    <div class="search-bar">
                        <input type="text" name="search" class="item" placeholder="Rechercher un sujet">
                        <button>
                            Rechercher
                        </button>
                    </div>
                </div>

                <div class="forum-subjects">
                    <div class="top">
                        <a href="new.php">
                            <button>
                                Nouveau sujet
                                <img src="../../assets/images/icons/new.svg" alt="Nouveau" width="18px">
                            </button>
                        </a>
                    </div>

                    <div id="subjects-list">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour charger les sujets via AJAX
        function loadSubjects() {
            fetch('../../backend/forum.php')
                .then(response => response.json())
                .then(data => {
                    const subjectsList = document.getElementById('subjects-list');
                    if (!subjectsList) return;
                    subjectsList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(subject => {
                            const subjectItem = document.createElement('a');
                            subjectItem.href = `this.php?ref=${subject.id}`
                            subjectItem.className = 'subject-item';
                            subjectItem.innerHTML = `
                                <div class='left'>
                                    <img src="../../assets/images/icons/me.svg" alt="Me" width="50px">
                                </div>

                                <div class='middle'>
                                    <span class='subject-title'>${subject.title}</span>
                                    <div class='user-info'>
                                        ${subject.user}
                                        ${subject.user_email}
                                    </div>
                                </div>
                            `;
                            let right = "<div class='right'>";
                            subject.tags.split(', ').forEach((tag) => {
                                right += `<span class='tag'>${tag}</span>`;
                            })
                            right += "</div>"
                            subjectItem.innerHTML += right;
                            subjectsList.appendChild(subjectItem);
                        });
                    } else {
                        subjectsList.innerHTML = 'Aucun sujet trouvé.';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }

        loadSubjects();
    });
</script>

</html>