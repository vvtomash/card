<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Cards_Wants extends \Collection {

	protected $entities = [];

	private function __construct() {}

	private static $instance;

	private static $filters = [];
	private static $allowedFilters = [
		'user_id', 'user_id:not'
	];

	public function load():Model_Cards_Wants {
		foreach (Model_Cards_Manager::loadAllWants(self::$filters) as $card) {
			$this->entities[$card['id']] = new Model_Cards_WantEntity(null, $card);
		}
		return $this;
	}

	public function setFilter(array $filters):Model_Cards_Wants {
		self::$filters = array_intersect_key($filters, array_flip(self::$allowedFilters));
		return $this;
	}

	public static function instance():Model_Cards_Wants {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}