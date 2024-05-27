<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Inscription</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include '../partials/link.php' ?>
</head>

<body>
	<div class="wrapper">
		<div class="inner">
			<img src="../../assets/images/image-1.png" alt="" class="image-1">
			<form action="../../backend/session.php" method="post" class="form <?php echo isset($_GET['login']) ? '' : 'active' ?>" id="signup">
				<span class="button" id="btn-1">Se connecter</span>
				<span class="title">
					Inscription <span class="not-selectable" style="color: #999;">Compte apprenant</span>
				</span>
				<div class="form-input-field">
					<input type="text" class="form-control" placeholder="Nom" name="nom" value="<?= $_GET['nom'] ?? '' ?>">
				</div>
				<div class="form-input-field">
					<input type="text" class="form-control" placeholder="Prénoms" name="prenoms" value="<?= $_GET['prenoms'] ?? '' ?>">
				</div>
				<div class="form-input-field">
					<input type="text" class="form-control" placeholder="Email" name="email" value="<?= $_GET['email'] ?? '' ?>">
				</div>
				<div class="form-input-field">
					<input type="password" class="form-control" placeholder="Mot de passe" name="password">
				</div>
				<div class="form-input-field">
					<input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="confirmpassword">
				</div>

				<div id="responseMessage" style="color: #dc3545; text-align: center;">
					<small>
						<?= $_GET['err'] ?? '' ?>
					</small>
				</div>

				<button type="submit">
					<span>Enregistrer</span>
				</button>
			</form>
			<form action="../../backend/session.php" method="post" class="form <?php echo isset($_GET['login']) ? 'active' : '' ?>" id="login">
				<span class="button" id="btn-2">S'inscrire</span>
				<span class="title">
					Connexion <span class="not-selectable" style="color: #999;">Compte apprenant</span>
				</span>
				<div class="form-input-field">
					<input type="text" class="form-control" name="login" placeholder="Email">
				</div>
				<div class="form-input-field">
					<input type="password" class="form-control" name="password" placeholder="Mot de passe">
				</div>

				<div id="responseMessage" style="color: #dc3545; text-align: center;">
					<small>
						<?= $_GET['error_message'] ?? '' ?>
					</small>
				</div>

				<button type="submit">
					<span>Se connecter</span>
				</button>
			</form>
			<img src="../../assets/images/image-2.png" alt="" class="image-2">
		</f>
	</div>

	<?= $_GET['password'] ?? '' ?>
</body>

<script src="../../assets/js/script.js"></script>

</html>