<?php
	require_once("templates/header.php");

	//verify if user is authenticated
	require_once("models/User.php");
	require_once("dao/UserDAO.php");

	$user = new User();
	$userDao = new UserDao($conn, $BASE_URL);
	$userData = $userDao->verifyToken(true);


?>

	<div id="main-container" class="container-fluid">
		<div class="offset-md-4 col-md-4 new-game-container">
			<h1 class="page-title">Adicionar Jogo</h1>
			<p class="page-description">Escreva sua experiência e compartilhe com a comunidade!</p>
			<form action="<?= $BASE_URL ?>game_process.php" id="add-game-form" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="type" value="create">
				<div class="form-group">
					<label for="title">Título do Jogo:</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do jogo">
				</div>
				<div class="form-group">
					<label for="image">Imagem da capa:</label>
					<input type="file" class="form-control-file" name="image" id="image" >
				</div>
				<div class="form-group">
					<label for="category">Categoria:</label>
					<select name="category" id="category" class="form-control">
						<option value="">Selecione</option>
						<option value="Ação">Ação e Aventura</option>
						<option value="RPG">RPG</option>
						<option value="Estratégia">Estratégia</option>
						<option value="Simulação">Simulação</option>
						<option value="Outra">Outra / não listada</option>
					</select>
				</div>
				<div class="form-group">
					<label for="trailer">Trailer:</label>
					<input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer">
				</div>
				<div class="form-group">
					<label for="description">Minha experiência com o jogo:</label>
					<textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva a sua experiência com o jogo"></textarea>
				</div>
				<input type="submit" class="btn card-btn" value="Adicionar Jogo">
			</form>
		</div>
	</div>

<?php
	require_once("templates/footer.php");
?>