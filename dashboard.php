<?php
	require_once("templates/header.php");

	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	require_once("dao/GameDAO.php");

	$user = new User();
	$userDao = new UserDao($conn, $BASE_URL);
	$gameDao = new GameDao($conn, $BASE_URL);

	//verify if user is authenticated
	$userData = $userDao->verifyToken(true);

	//get games by user id
	$userGames = $gameDao->getGamesByUserId($userData->id);

?>


<div id="main-container" class="container-fluid">
	<h2 class="section-title">Dashboard</h2>
	<p class="section-description">Edite aqui as informações dos jogos enviados</p>
	<div class="col-md-12" id="add-game-container">
		<a href="<?= $BASE_URL ?>newgame.php" class="btn card-btn">
			<i class="fas fa-plus"></i> Adicionar Jogo
		</a>
	</div>
	<div class="col-md-12" id="games-dashboard">
		<table class="table">
			<thead>
				<th scope="col">#</th>
				<th scope="col">Título</th>
				<th scope="col">Nota</th>
				<th scope="col" class="actions-column">Ações</th>
			</thead>
			<tbody>
				<?php foreach($userGames as $game): ?>
				<tr>
					<td scope="row"><?= $game->id ?></td>
					<td><a href="<?= $BASE_URL ?>game.php?id=<?= $game->id ?>" class="table-game-title"><?= $game->title ?></a></td>
					<td><i class="fas fa-star"></i> <?= $game->rating ?></td>
					<td class="actions-column">
						<a href="<?= $BASE_URL ?>editgame.php?id=<?= $game->id ?>" class="edit-btn">
							<i class="far fa-edit"></i> Editar
						</a>
						<form action="<?= $BASE_URL ?>game_process.php" method="POST">
							<input type="hidden" name="type" value="delete">
							<input type="hidden" name="id" value="<?= $game->id ?>">
							<button type="submit" class="delete-btn">
								<i class="fas fa-times"></i> Excluir
							</button>
						</form>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>


<?php
	require_once("templates/footer.php");
?>