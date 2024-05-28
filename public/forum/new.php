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
?>

<body>
    <div class="main">
        <div class="sidebar">
            <?php include_once('../partials/sidebar.php') ?>
        </div>
        <div class="main-container">
            <div class="container" style="background: aliceblue">
                <div style="margin-top: 10%; width: 40%">
                    <div class="header" style="display: flex; flex-direction: column; width: 100%">
                        <span class="title" style="width: 100%; text-wrap: wrap; text-align: left">
                            Créer un nouveau sujet
                        </span>
                        <span class="subtitle">
                            Afin de maximiser vos chances d'obtenir de l'aide,
                            essayez de décrire au mieux votre problème (ne copiez pas des centaines de lignes).
                            Essayez de simplifier votre problème au maximum.
                        </span>
                    </div>
                </div>

                <form action="../../backend/forum.php" method="post" style="
                    width: 50%; padding: 1rem; display: flex;
                    flex-direction: column; gap: 20px; height: 100vh;
                    justify-content: center">
                    <div style="display: flex; gap: 10px; align-items: center">
                        <div style="width: 100%">
                            <label for="title">Titre</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div style="width: 100%">
                            <label for="tag">Tags</label>
                            <input type="text" name="tag" id="tag" class="form-control" required>
                        </div>
                    </div>

                    <div>
                        <label for="desc">Description</label>
                        <textarea name="desc" id="desc" rows="15" style="width: 100%; height: auto;" class="form-control" required>
                            </textarea>
                    </div>

                    <button type="submit" style="cursor: pointer; border: none; min-height: 50px; width: 200px; background: transparent; border-radius: 5px; color: #fff; background: rgb(25, 29, 58); font-weight: 600;">
                        Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>