<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

//get type of form
$type = filter_input(INPUT_POST, "type");

//verify type of form
if($type === "register") {

	//map the inputs
	$name = filter_input(INPUT_POST, "name");
	$lastname = filter_input(INPUT_POST, "lastname");
	$email = filter_input(INPUT_POST, "email");
	$password = filter_input(INPUT_POST, "password");
	$confirmPassword = filter_input(INPUT_POST, "confirmPassword");

	//validate minimum data
	if($name && $lastname && $email && $password) {

		//verify password equals
		if($password === $confirmPassword) {

			//verify if email already exists
			if($userDao->findByEmail($email) === false) {

				$user = new User();

				//create token and password
				$userToken = $user->generateToken();
				$finalPassword = $user->generatePassword($password);

				$user->name = $name;
				$user->lastname = $lastname;
				$user->email = $email;
				$user->password = $finalPassword;
				$user->token = $userToken;

				$auth = true;

				$userDao->create($user, $auth);

			} else {
				//send error message
				$message->setMessage("Este e-mail já existe no sistema, tente outro e-mail.", "error", "back");
			}

		} else {
			//send error message
			$message->setMessage("As senhas precisam ser iguais.", "error", "back");
		}

	} else {
		//send error message
		$message->setMessage("Por favor, preencha todos os campos.", "error", "back");

	}

} else if($type === "login") {

	$email = filter_input(INPUT_POST, "email");
	$password = filter_input(INPUT_POST, "password");

		//try to authenticate user
	if($userDao->authenticateUser($email, $password)) {

		$message->setMessage("Seja bem-vindo(a)!", "sucess", "editprofile.php");

		//redirect user in case canot athenticate
	} else {
		//send error message
		$message->setMessage("Usuário e/ou senha incorretos.", "error", "back");
	}
	
} else {

	//send error message
	$message->setMessage("Informações inválidas.", "error", "index.php");
}