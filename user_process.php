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

//update user
if($type === "update") {

	//get user data
	$userData = $userDao->verifyToken();

	//receive POST data
	$name = filter_input(INPUT_POST, "name");
	$lastname = filter_input(INPUT_POST, "lastname");
	$email = filter_input(INPUT_POST, "email");
	$bio = filter_input(INPUT_POST, "bio");

	//create a new user object
	$user = new User();

	//fill in user data
	$userData->name = $name;
	$userData->lastname = $lastname;
	$userData->email = $email;
	$userData->bio = $bio;

	//upload user image
	if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

		$image = $_FILES["image"];
		$imageTypes = ["image/jpeg", "image/jpg", "image/png"];
		$jpgArray = ["image/jpeg", "image/jpg"];

		//check type of image
		if(in_array($image["type"], $imageTypes)) {

			//check if image is JPG
			if(in_array($image, $jpgArray)) {

				$imageFile = imagecreatefromjpeg($image["tmp_name"]);

				//image is PNG
			} else {
				$imageFile = imagecreatefrompng($image["tmp_name"]);
			}

			$imageName = $user->GenerateImageName();
			imagejpeg($imageFile, "./img/users/" . $imageName, 100);
			$userData->image = $imageName;

		} else {
			$message->setMessage("Tipo de imagem inválida! Somente png ou jpg/jpeg", "error", "back");
		}

	}

	//update the user
	$userDao->update($userData);

	//update password user
} else if($type === "changepassword") {

	//receive POST data
	$password = filter_input(INPUT_POST, "password");
	$confirmpassword = filter_input(INPUT_POST, "confirmpassword");
	
	//get user data
	$userData = $userDao->verifyToken();
	$id = $userData->id;

	if($password === $confirmpassword) {

		//create a new user object
		$user = new User();

		$finalpassword = $user->generatePassword($password);

		$user->password = $finalpassword;
		$user->id = $id;

		$userDao->changePassword($user);



	} else {
		//send error message
		$message->setMessage("As senhas precisam ser iguais!", "error", "back");
	}

} else {
	//send error message
	$message->setMessage("Informações inválidas.", "error", "index.php");
}