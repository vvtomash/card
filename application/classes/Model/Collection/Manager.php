<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:51
 */
class Model_Collection_Manager extends DBModel {

	public static function loadUserCollection(int $userId, array $filters, int $limit, int $offset = 0):Database_Result_Cached {
		$filterWithTable = [];
		foreach($filters as $field => $value) {
			$filterWithTable[$field] = $value;
		}
		$sql = "select c.*,
				  (select count(*) from `user_collection` uc where user_id = $userId and uc.card_id = c.id and uc.`status` = 'active') count
				from `cards` c
 				join `card_info` ci on c.id = ci.card_id
 				where ".self::buildWhereExpression($filterWithTable)."
				order by c.`id` asc
				limit $offset, $limit;";
//Log::instance()->add(Log::INFO, $sql);
//		Log::instance()->write();
		return static::getDb()->query(Database::SELECT, $sql);
	}
}