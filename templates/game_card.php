<?php

	if(empty($game->image)) {
		$game->image = "game_cover.jpg";
	}

?>
<div class="card game-card">
	<div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/games/<?= $game->image ?>')"></div>
		<div class="card-body">
			<p class="card-rating">
				<i class="fas fa-star"></i>
				<span class="rating"> <?= $game->rating ?></span>
			</p>
			<h5 class="card-title">
				<a href="<?= $BASE_URL ?>game.php?id=<?= $game->id ?>"><?= $game->title ?></a>
			</h5>
			<a href="<?= $BASE_URL ?>game.php?id=<?= $game->id ?>" class="btn btn-primary rate-btn">Avaliar</a>
			<a href="<?= $BASE_URL ?>game.php?id=<?= $game->id ?>" class="btn btn-primary card-btn">Ver</a>
		</div>
</div>