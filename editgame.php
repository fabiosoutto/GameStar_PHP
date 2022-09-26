<?php
	require_once("templates/header.php");

	//verify if user is authenticated
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	require_once("dao/GameDAO.php");

	$user = new User();
	$userDao = new UserDao($conn, $BASE_URL);
	$userData = $userDao->verifyToken(true);

	$gameDao = new GameDAO($conn, $BASE_URL);

	$id = filter_input(INPUT_GET, "id");

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


?>


<div id="main-container" class="container-fluid">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6 offset-md-1">
				<h1><?= $game->title ?></h1>
				<p class="page-description">Formulário para edição de dados:</p>
				<form action="<?= $BASE_URL ?>game_process.php" id="edit-game-form" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="type" value="update">
					<input type="hidden" name="id" value="<?= $game->id ?>">
					<div class="form-group">
						<label for="title">Título do Jogo:</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do jogo" value="<?= $game->title ?>">
					</div>
					<div class="form-group">
						<label for="image">Imagem da capa:</label>
						<br>
						<input type="file" class="form-control-file" name="image" id="image" >
					</div>
					<div class="form-group">
						<label for="category">Categoria:</label>
						<select name="category" id="category" class="form-control">
							<option value="">Selecione</option>
							<option value="Ação" <?= $game->category === "Ação" ? "selected" : "" ?>>Ação e Aventura</option>
							<option value="RPG" <?= $game->category === "RPG" ? "selected" : "" ?>>RPG</option>
							<option value="Estratégia" <?= $game->category === "Estratégia" ? "selected" : "" ?>>Estratégia</option>
							<option value="Simulação" <?= $game->category === "Simulação" ? "selected" : "" ?>>Simulação</option>
							<option value="Outra" <?= $game->category === "Outra" ? "selected" : "" ?>>Outra / não listada</option>
						</select>
					</div>
					<div class="form-group">
						<label for="trailer">Trailer:</label>
						<input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?= $game->trailer ?>">
					</div>
					<div class="form-group">
						<label for="description">Minha experiência com o jogo:</label>
						<textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva a sua experiência com o jogo"><?= $game->description ?></textarea>
					</div>
					<input type="submit" class="btn card-btn" value="Atualizar Jogo">
				</form>
			</div>
			<div class="col-md-3">
				<div class="game-image-container edit-page-img" style="background-image: url('<?= $BASE_URL ?>img/games/<?= $game->image ?>')"></div><br>
				<iframe src="<?= $game->trailer ?>" width="425" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>



<?php
	require_once("templates/footer.php");
?>