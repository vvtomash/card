<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Collection_UserCollection extends \Collection {

	protected $entities = [];
	protected $userId;

	private static $allowedFilters = [
		'type', 'expansions', 'color', 'cmc'
	];

	private $filters = [];

	private function __construct($userId) {
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load(int $limit, int $offset = 0):Model_Collection_UserCollection {
		foreach (Model_Collection_Manager::loadUserCollection($this->userId, $this->getFilters(), $limit, $offset) as $card) {
			$this->entities[$card['id']] = $card;
		}
		return $this;
	}

	public static function instance(int $userId):Model_Collection_UserCollection {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new self($userId);
		}
		return self::$instances[$userId];
	}

	public function setFilter(string $filter, $value):Model_Collection_UserCollection {
		if (empty($value)) {
			return $this;
		}
		if (!in_array($filter, self::$allowedFilters)) {
			throw new Exception('Filter not allowed');
		};
		$this->filters[$filter] = $value;
		return $this;
	}

	public function getFilters():array {
		return $this->filters;
	}
}