<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Cards_UserWants extends \Collection {

	protected $entities = [];
	protected $userId;

	private function __construct($userId) {
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load(int $limit, int $offset = 0):Model_Cards_UserWants {
		foreach (Model_Cards_Manager::loadUserWants($this->userId, $limit, $offset) as $card) {
			$this->entities[$card['id']] = new Model_Cards_UserWantEntity(null, $card);
		}
		return $this;
	}

	public static function instance(int $userId):Model_Cards_UserWants {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new self($userId);
		}
		return self::$instances[$userId];
	}

	public function remove(int $id):bool {
		return Model_Cards_Manager::removeUserWant($this->userId, $id);
	}

	public function add(int $id):Model_Cards_UserWantEntity {
		$card = new Model_Cards_UserWantEntity();
		$card->card_id = $id;
		$card->user_id = $this->userId;
		if ($card->save()) {
			$card->added_timestamp = date('Y-m-d H:i:s');
			return $card;
		}
		return null;
	}

	public function totalInfo():array {
		return Model_Cards_Manager::totalInfoUserWants($this->userId);
	}

	public  static function checkAvailableTrades(int $userId):bool {
		$profile = new Model_Profile(['user_id' => $userId]);
		return $profile->checkFullness();
	}
}