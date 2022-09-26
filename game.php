<?php
	require_once("templates/header.php");

	require_once("models/Game.php");
	require_once("dao/GameDAO.php");
	require_once("dao/ReviewDAO.php");

	//get game id
	$id = filter_input(INPUT_GET, "id");

	$game;
	$gameDao = new GameDAO($conn, $BASE_URL);
	$reviewDao = new ReviewDAO($conn, $BASE_URL);

	if(empty($id)) {

		$message->setMessage("Jogo não encontrado!", "error", "index.php");

	} else {

		$game = $gameDao->findById($id);

		//verify if game exists
		if(!$game) {

			$message->setMessage("Jogo não encontrado!", "error", "index.php");

		}
	}

	//check if game image exists
	if($game->image == "") {
		$game->image = "game_cover.jpg";
	}

	//check if the game belongs to the user
	$userOwnsGame = false;

	if(!empty($userData)) {

		if($userData->id === $game->users_id) {
			$userOwnsGame = true;

		}

		//get the games review
    $alreadyReviewed = $reviewDao->hasAlreadyReview($id, $userData->id);

	}

	//get the games review
	$gameReviews = $reviewDao->getGameReview($game->id);


?>

<div id="main-container" class="container-fluid">
	<div class="row">
		<div class="offset-md-1 col-md-6 game-container">
			<h1 class="page-title"><?= $game->title ?></h1>
			<p class="game-details">
				<span><?= $game->category ?></span>
				<span class="pipe"></span>
				<span><i class="fas fa-star"></i> <?= $game->rating ?></span>
			</p>
			<iframe src="<?= $game->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<p class="page-game-desc"><?= $game->description ?></p>
		</div>
		<div class="col-md-4">
			<div class="game-image-container" style="background-image: url('<?= $BASE_URL ?>/img/games/<?= $game->image ?>')"></div>
		</div>
		<div class="offset-md-1 col-md-10" id="reviews-container">
			<h3 id="reviews-title">Avaliações:</h3>
			<!-- verify if reviews are habilited for the user -->
			<?php if(!empty($userData) && !$userOwnsGame && !$alreadyReviewed): ?>
			<div class="col-md-12" id="review-form-container">
				<h4>Envie sua avaliação:</h4>
				<p class="page-description">Preencha o formulário com sua nota e comentário sobre o jogo.</p>
				<form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
				<input type="hidden" name="type" value="create">
				<input type="hidden" name="games_id" value="<?= $game->id ?>">
				<div class="form-group">
					<label for="rating">Nota do jogo:</label>
					<select name="rating" id="rating" class="form-control">
						<option value="">Selecione</option>
						<option value="5">5</option>
						<option value="4">4</option>
						<option value="3">3</option>
						<option value="2">2</option>
						<option value="1">1</option>
					</select>
				</div>
				<div class="form-group">
					<label for="review">Seu comentário:</label>
					<textarea name="review" id="review" rows="3" class="form-control" placeholder="Conte sua experiência com o jogo"></textarea>
				</div>
				<input type="submit" class="btn card-btn" value="Enviar">
				</form>
			</div>
			<?php endif; ?>
			<!-- comments here -->
			<?php foreach($gameReviews as $review): ?>
				<?php require("templates/user_review.php"); ?>
			<?php endforeach; ?>
			<?php if(count($gameReviews) == 0): ?>
				<p class="empty-list">Não há comentários para este jogo!</p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
	require_once("templates/footer.php");
?>