<?php
	require_once("templates/header.php");
	require_once("dao/GameDAO.php");

	//DAO of the Games
	$gameDao = new GameDAO($conn, $BASE_URL);

	$latestGames = $gameDao->getLatestGames();
	$actionGames = $gameDao->getGamesByCategory("Ação");
	$rpgGames = $gameDao->getGamesByCategory("RPG");
	$strategyGames = $gameDao->getGamesByCategory("Estratégia");
	$simulationGames = $gameDao->getGamesByCategory("Simulação");

?>

	<div id="main-container" class="container-fluid">

		<h2 class="section-title">Últimos Jogos cadastrados</h2>
		<p class="section-description">Vejas as experiências dos jogadores e os últimos jogos adicionados no GameStar</p>
		<div class="games-container">
			<?php foreach($latestGames as $game): ?>
				<?php require("templates/game_card.php"); ?>
			<?php endforeach; ?>
			<?php if(count($latestGames) === 0): ?>
				<p class="empty-list">Não há jogos cadastrados nesta categoria!</p>
			<?php endif; ?>
		</div>

		<h2 class="section-title">Ação e Aventura</h2>
		<p class="section-description">Confira os jogos adicionados nesta categoria</p>
		<div class="games-container">
			<?php foreach($actionGames as $game): ?>
				<?php require("templates/game_card.php"); ?>
			<?php endforeach; ?>
			<?php if(count($actionGames) === 0): ?>
				<p class="empty-list">Não há jogos cadastrados nesta categoria!</p>
			<?php endif; ?>
		</div>

		<h2 class="section-title">RPG (Role Playing Game)</h2>
		<p class="section-description">Confira os jogos adicionados nesta categoria</p>
		<div class="games-container">
			<?php foreach($rpgGames as $game): ?>
				<?php require("templates/game_card.php"); ?>
			<?php endforeach; ?>
			<?php if(count($rpgGames) === 0): ?>
				<p class="empty-list">Não há jogos cadastrados nesta categoria!</p>
			<?php endif; ?>
		</div>

		<h2 class="section-title">Estratégia</h2>
		<p class="section-description">Confira os jogos adicionados nesta categoria</p>
		<div class="games-container">
			<?php foreach($strategyGames as $game): ?>
				<?php require("templates/game_card.php"); ?>
			<?php endforeach; ?>
			<?php if(count($strategyGames) === 0): ?>
				<p class="empty-list">Não há jogos cadastrados nesta categoria!</p>
			<?php endif; ?>
		</div>

		<h2 class="section-title">Simulação</h2>
		<p class="section-description">Confira os jogos adicionados nesta categoria</p>
		<div class="games-container">
			<?php foreach($simulationGames as $game): ?>
				<?php require("templates/game_card.php"); ?>
			<?php endforeach; ?>
			<?php if(count($simulationGames) === 0): ?>
				<p class="empty-list">Não há jogos cadastrados nesta categoria!</p>
			<?php endif; ?>
		</div>

	</div>

<?php
	require_once("templates/footer.php");
?>