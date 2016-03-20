<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Cards_UserCards extends \Collection {

	protected $entities = [];
	protected $userId;

	private function __construct($userId) {
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load():Model_Cards_UserCards {
		foreach (Model_Cards_Manager::loadUserCards($this->userId) as $card) {
			$this->entities[$card['id']] = new Model_Cards_UserCardEntity(null, $card);
		}
		return $this;
	}

	public static function instance(int $userId):Model_Cards_UserCards {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new self($userId);
		}
		return self::$instances[$userId];
	}

	public function remove(int $id):bool {
		return Model_Cards_Manager::removeUserCard($this->userId, $id);
	}

	public function add(int $id):Model_Cards_UserCardEntity {
		$card = new Model_Cards_UserCardEntity();
		$card->card_id = $id;
		$card->user_id = $this->userId;
		if ($card->save()) {
			return $card;
		}
		return null;
	}
}