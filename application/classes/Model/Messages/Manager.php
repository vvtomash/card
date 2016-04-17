<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:51
 */
class Model_Messages_Manager extends DBModel {

	public static function loadUserMessages(int $userId, array $filters = [], int $limit, int $offset = 0):Database_Result_Cached {
		$filters['to_id'] = $userId;
		$sql = "select um.*,
					a.email `author:email`, a.username `author:username`
				from `user_messages` um
 				left join `users` a on a.id = um.from_id
 				where ".self::buildWhereExpression($filters)."
				order by um.`id` desc
				limit $offset, $limit;";
		return static::getDb()->query(Database::SELECT, $sql);
	}

	public static function getCountMessages(int $userId, array $filters = []):int {
		$filters['to_id'] = $userId;
		$sql = "select count(*) `count`
				from `user_messages` um
 				where ".self::buildWhereExpression($filters);
		return static::getDb()->query(Database::SELECT, $sql)->get('count');
	}

	public static function getCountersMessages(int $userId, array $filters = []):Database_Result_Cached {
		$filters['to_id'] = $userId;
		$sql = "select count(*) `count`, `status`
				from `user_messages` um
 				where ".self::buildWhereExpression($filters)."
 				group by `status`";
		return static::getDb()->query(Database::SELECT, $sql);
	}
}