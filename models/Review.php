<?php

class Review {

	public $id;
	public $rating;
	public $review;
	public $users_id;
	public $games_id;

}

interface ReviewDAOInterface {

	public function buildReview($data);
	public function create(Review $review);
	public function getGameReview($id);
	public function hasAlreadyReview($id, $userId);
	public function getRatings($id);


}