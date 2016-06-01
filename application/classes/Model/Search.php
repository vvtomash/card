<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 14.03.16
 * Time: 22:14
 */
class Model_Search extends DBModel {

	const LIMIT = 30;

	const SEARCH_TEXT_MIN_LEN = 3;

	public static function cardsByName(string $searchName, int $offset = 0, int $limit = self::LIMIT):array {
		if (strlen($searchName) < self::SEARCH_TEXT_MIN_LEN) {
			throw new SearchExeption('Too small text for search');
		}
		$sql = "SELECT c.*, s.short_name `set_code` FROM `cards` c
			JOIN `card_info` ci ON ci.`card_id` = c.`id`
			JOIN `sets` s ON s.`id` = c.`set_id`
			WHERE c.`name` LIKE  ".static::getDb()->escape("%$searchName%").
			" ORDER BY ci.multiverse_id DESC
			LIMIT $offset, $limit;";
		return static::getDb()->query(Database::SELECT, $sql)->as_array();
	}

	public static function countResult(string $searchName):int {
		if (strlen($searchName) < self::SEARCH_TEXT_MIN_LEN) {
			throw new SearchExeption('Too small text for search');
		}
		$sql = "SELECT count(*) cnt FROM `cards` c
			WHERE c.`name` LIKE  ".static::getDb()->escape("%$searchName%");
		$result = static::getDb()->query(Database::SELECT, $sql)->as_array();
		return Arr::get((array)reset($result), 'cnt', 0);
	}
}

class SearchExeption extends Kohana_Exception {};