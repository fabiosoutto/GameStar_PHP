<?php

	require_once("globals.php");
	require_once("db.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");

	//message component
	$message = new Message($BASE_URL);
	$flashMessage = $message->getMessage();

	if(!empty($flashMessage["msg"])) {
		//clean the message
		$message->clearMessage();
	}

	$userDao = new UserDAO($conn, $BASE_URL);
	$userData = $userDao->verifyToken(false);

	//echo '<pre>';
	//print_r($userData); exit;  //testing user data

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GameStar</title>
	<link rel="short icon" href="<?= $BASE_URL ?>img/favicon.ico" />
	<!--custom css-->
	<link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css" />
	<!--Bootstrap css-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.1/css/bootstrap.css" integrity="sha512-tBwPRcI1t+0jTsIMtf//+V1f0xAWHh7pvPE82A2n5FcBrzl6b0LRE6XnxUTRHti59y4Js7z4Wb/zal2HBsVVOQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!--Fontawesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<header>
		<nav id="main-navbar" class="navbar navbar-expand-lg">
			<a class="navbar-brand" href="<?= $BASE_URL ?>">
				<img src="<?= $BASE_URL ?>img/logo.svg" alt="GameStar" id="logo">
				<span id="gamestar-title">GameStar</span>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
			<form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
        <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Pesquisar jogos" aria-label="Search">
        <button class="btn my-2 my-sm-0" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="navbar-nav">
					<?php if($userData): ?>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>newgame.php" class="nav-link">
								<i class="far fa-plus-square"></i> Incluir Jogos
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>dashboard.php" class="nav-link">Meus Jogos</a>
						</li>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold"><?= $userData->name ?></a>
						</li>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
						</li>
					<?php else: ?>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
	</header>
	<?php if(!empty($flashMessage["msg"])): ?>
		<div class="msg-container">
			<p class="msg <?= $flashMessage["type"] ?>"><?= $flashMessage["msg"] ?></p>
		</div>
	<?php endif; ?>
	