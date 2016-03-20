<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 14.03.16
 * Time: 22:22
 */

class DBModel extends Model {

	protected static $db;

	public static function getDb():Database_PDO {
		if (empty(static::$db)) {
			static::$db = Database::instance('PDO');
		}
		return static::$db;
	}
}