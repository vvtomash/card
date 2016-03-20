<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 14.03.16
 * Time: 22:14
 */
class Model_Search extends DBModel {

	const SEARCH_TEXT_MIN_LEN = 2;

	public static function cardsByName(string $searchName):array {
		if (strlen($searchName) < self::SEARCH_TEXT_MIN_LEN) {
			throw new SearchExeption('Too small text for search');
		}
		$sql = "select * from `cards`
			where `name` LIKE  ".static::getDb()->escape("%$searchName%");
		return static::getDb()->query(Database::SELECT, $sql)->as_array();
	}
}

class SearchExeption extends Kohana_Exception {};