<?php
	require_once("templates/header.php")
?>

	<div id="main-container" class="container-fluid">
		<div class="col-md-12">
			<div id="auth-row" class="row">
				<div id="login-container" class="col-md-4">
					<h2>Entre</h2>
					<form action="<?= $BASE_URL ?>auth_process.php" method="POST">
						<input type="hidden" name="type" value="login">
						<div class="form-group">
							<label for="email">E-mail</label>
							<input id="email" name="email" type="email" class="form-control" placeholder="Digite seu e-mail" >
						</div>
						<div class="form-group">
							<label for="password">Senha</label>
							<input id="password" name="password" type="password" class="form-control" placeholder="Digite sua senha" >
						</div>
						<input type="submit" class="btn card-btn" value="Entrar">
					</form>
				</div>
				<div id="register-container" class="col-md-4">
					<h2>Cadastre-se</h2>
					<form action="<?= $BASE_URL ?>auth_process.php" method="POST">
						<input type="hidden" name="type" value="register">
						<div class="form-group">
							<label for="email">E-mail</label>
							<input id="email" name="email" type="email" class="form-control" placeholder="Digite seu e-mail" 
						<div class="form-group">
							<label for="name">Nome</label>
							<input id="name" name="name" type="text" class="form-control" placeholder="Digite seu nome" >
						</div>
						<div class="form-group">
							<label for="lastname">Sobrenome</label>
							<input id="lastname" name="lastname" type="text" class="form-control" placeholder="Digite seu sobrenome" >
						</div>
						<div class="form-group">
							<label for="password">Senha</label>
							<input id="password" name="password" type="password" class="form-control" placeholder="Digite sua senha" >
						</div>
						<div class="form-group">
							<label for="confirmPassword">Confirmação de Senha</label>
							<input id="confirmPassword" name="confirmPassword" type="password" class="form-control" placeholder="Confirme sua senha" >
						</div>
						<input type="submit" class="btn card-btn" value="Cadastrar">
					</form>
				</div>
			</div>
		</div>
	</div>

<?php
	require_once("templates/footer.php")
?>