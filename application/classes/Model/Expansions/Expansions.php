<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Expansions_Expansions extends \Collection {

	protected $entities = [];

	private function __construct() {}

	private static $instance;

	public function load():Model_Expansions_Expansions {
		foreach (Model_Expansions_Manager::loadSets() as $set) {
			$this->entities[$set['id']] = new Model_Sets_SetEntity(null, $set);
		}
		return $this;
	}

	public static function instance():Model_Expansions_Expansions {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}