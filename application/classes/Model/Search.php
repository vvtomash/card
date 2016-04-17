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
		$sql = "select c.* from `cards` c
			join `card_info` ci on ci.`card_id` = c.`id`
			where c.`name` LIKE  ".static::getDb()->escape("%$searchName%").
			" order by ci.multiverse_id desc;";
		return static::getDb()->query(Database::SELECT, $sql)->as_array();
	}
}

class SearchExeption extends Kohana_Exception {};