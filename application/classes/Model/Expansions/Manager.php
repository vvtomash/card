<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:51
 */
class Model_Expansions_Manager extends DBModel {

	public static function loadExpansions():Database_Result_Cached {
		$sql = "select * from `expansion`;";
		return static::getDb()->query(Database::SELECT, $sql);
	}
}