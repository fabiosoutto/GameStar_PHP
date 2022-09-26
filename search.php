<?php
	require_once("templates/header.php");
	require_once("dao/GameDAO.php");

	//DAO of the Games
	$gameDao = new GameDAO($conn, $BASE_URL);

	//get user search
	$q = filter_input(INPUT_GET, "q");

	$games = $gameDao->findByTitle($q);

?>

	<div id="main-container" class="container-fluid">

		<h2 class="section-title" id="search-title">Sua pesquisa sobre: <span id="search-result"><?= $q ?></span></h2>
		<p class="section-description">Resultados de busca com base na sua pesquisa.</p>
		<div class="games-container">
			<?php foreach($games as $game): ?>
				<?php require("templates/game_card.php"); ?>
			<?php endforeach; ?>
			<?php if(count($games) === 0): ?>
				<p class="empty-list">Não há jogos para esta busca! <a href="<?= $BASE_URL ?>" class="back-link">Voltar</a> </p>
			<?php endif; ?>
		</div>

	</div>

<?php
	require_once("templates/footer.php");
?>

