<?php
	require_once("templates/header.php");

	//verify if user is authenticated
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	require_once("dao/GameDAO.php");

	$user = new User();
	$userDao = new UserDao($conn, $BASE_URL);
	$gameDao = new GameDao($conn, $BASE_URL);

	//receive user id
	$id = filter_input(INPUT_GET, "id");

	if(empty($id)) {

		if(!empty($userData)) {

			$id = $userData->id;

		} else {

			$message->setMessage("Usuário não encontrado!", "error", "index.php");

		}

	} else {

		$userData = $userDao->findById($id);

		//if user not found
		if(!$userData) {

			$message->setMessage("Usuário não encontrado!", "error", "index.php");

		}

	}

	// get the user fullname and image
	$fullName = $user->getFullName($userData);

	//default image if the user does not have
	if($userData->image == "") {
		$userData->image = "user.png";
	}

	//get the games the user added
	$userGames = $gameDao->getGamesByUserId($id);

?>


<div id="main-container" class="container-fluid">
	<div class="col-md-8 offset-md-2">
		<div class="row profile-container">
			<div class="col-md-12 about-container">
				<h1 class="page-title"><?= $fullName ?></h1>
				<div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
				<h3 class="about-title">Bio :</h3>
				<?php if(!empty($userData->bio)): ?>
					<p class="profile-description"><?= $userData->bio ?></p>
				<?php else: ?>
					<p class="profile-description">O usuário não preencheu sua bio!</p>
				<?php endif; ?>
			</div>
			<div class="col-md-12 added-games-container">
				<h3>Jogos enviados :</h3>
				<div class="games-container">
					<?php foreach($userGames as $game): ?>
					<?php require("templates/game_card.php"); ?>
					<?php endforeach; ?>
					<?php if(count($userGames) === 0): ?>
					<p class="empty-list">Não há jogos cadastrados pelo usuário!</p>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
	require_once("templates/footer.php");
?>