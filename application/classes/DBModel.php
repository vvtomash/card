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

	protected static function buildWhereExpression(array $filters = []):string {
		$where = [1];
		foreach ($filters as $field => $value) {
			$negative = false;
			if (strpos($field, ':') !== false) {
				list($field, $negative) = explode(':', $field);
			}
			$field = '`'.implode('`.`', explode('.', $field)).'`';
			if (is_array($value)) {
				$operator = $negative === 'not' ? 'not in' : 'in';
				$where[] = "$field $operator (".implode(',', (array_map([static::getDb(), 'escape'], $value))).")";
			} else {
				$operator = $negative === 'not' ? '!=' : '=';
				$where[] = "$field $operator ".static::getDb()->escape($value);
			}
		}
		return implode(' and ', $where);
	}

}