<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Game.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/GameDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$gameDao = new GameDAO($conn, $BASE_URL);

//get type of form
$type = filter_input(INPUT_POST, "type");

//get user data
$userData = $userDao->verifyToken();

if($type === "create") {

	//receive input data
	$title = filter_input(INPUT_POST, "title");
	$description = filter_input(INPUT_POST, "description");
	$trailer = filter_input(INPUT_POST, "trailer");
	$category = filter_input(INPUT_POST, "category");

	$game = new Game();

	// minimum validate data
	if(!empty($title) && !empty($description) && !empty($category)) {

		$game->title = $title;
		$game->description = $description;
		$game->trailer = $trailer;
		$game->category = $category;
		$game->users_id = $userData->id;

		//upload game image
		if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

			//check if data is image
			$image = $_FILES["image"];
			$imageTypes = ["image/jpeg", "image/jpg", "image/png"];
			$jpgArray = ["image/jpeg", "image/jpg"];

			//checking image types
			if(in_array($image["type"], $imageTypes)) {

				//checking if image is JPG
				if(in_array($image["type"], $jpgArray)) {
					$imageFile = imagecreatefromjpeg($image["tmp_name"]);
				} else {
					$imageFile = imagecreatefrompng($image["tmp_name"]);
				}

				//Generate the Image Name
				$imageName = $game->GenerateImageName();

				//Saving the image in the folder
				imagejpeg($imageFile, "./img/games/" . $imageName, 100);

				$game->image = $imageName;

			} else {

				$message->setMessage("Tipo de imagem inválida! Somente png ou jpg/jpeg", "error", "back");

			}
		}

		//Testing...
		//echo '<pre>';
		//print_r($_POST); print_r($_FILES); exit;

		$gameDao->create($game);

	} else {

		//send error message
		$message->setMessage("Informações mínimas: título, descrição e categoria!", "error", "back");

	}

}else if($type === "delete"){

	//receipt the data from
	$id = filter_input(INPUT_POST, "id");

	$game = $gameDao->findById($id);

	if($game) {

		//check if the game belongs to the user
		if($game->users_id === $userData->id) {

			$gameDao->destroy($game->id);

		} else {

			$message->setMessage("Informações inválidas.", "error", "index.php");

		}

	} else {

		$message->setMessage("Informações inválidas.", "error", "index.php");

	}

} else if($type === "update") {

	//receive input data
	$title = filter_input(INPUT_POST, "title");
	$description = filter_input(INPUT_POST, "description");
	$trailer = filter_input(INPUT_POST, "trailer");
	$category = filter_input(INPUT_POST, "category");
	$id = filter_input(INPUT_POST, "id");

	$gameData = $gameDao->findById($id);

	//check if found the game
	if($gameData) {

		//check if the game belongs to the user
		if($gameData->users_id === $userData->id) {

			// minimum validate data
			if(!empty($title) && !empty($description) && !empty($category)) {

				//edit the game
				$gameData->title = $title;
				$gameData->description = $description;
				$gameData->trailer = $trailer;
				$gameData->category = $category;

				//upload game image
				if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

					//check if data is image
					$image = $_FILES["image"];
					$imageTypes = ["image/jpeg", "image/jpg", "image/png"];
					$jpgArray = ["image/jpeg", "image/jpg"];

					//checking image types
					if(in_array($image["type"], $imageTypes)) {

						//checking if image is JPG
						if(in_array($image["type"], $jpgArray)) {
							$imageFile = imagecreatefromjpeg($image["tmp_name"]);
						} else {
							$imageFile = imagecreatefrompng($image["tmp_name"]);
						}

						//Generate the Image Name
						$imageName = $gameData->GenerateImageName();

						//Saving the image in the folder
						imagejpeg($imageFile, "./img/games/" . $imageName, 100);

						$gameData->image = $imageName;

					} else {

						$message->setMessage("Tipo de imagem inválida! Somente png ou jpg/jpeg", "error", "back");

					}
				}

				$gameDao->update($gameData);

			} else {

				//send error message
				$message->setMessage("Informações mínimas: título, descrição e categoria!", "error", "back");

			}

			

		} else {

			$message->setMessage("Informações inválidas.", "error", "index.php");

		}

	} else {

		$message->setMessage("Informações inválidas.", "error", "index.php");

	}

} else {

	//send error message
	$message->setMessage("Informações inválidas.", "error", "index.php");

}
