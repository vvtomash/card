<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:51
 */
class Model_Trades_Manager extends DBModel {

	public static function loadOutUserTrades(int $userId, array $filters = []):Database_Result_Cached {
		$filters['sender_id'] = $userId;
		return self::loadTrades($filters);
	}

	public static function loadInUserTrades(int $userId, array $filters = []):Database_Result_Cached {
		$filters['recipient_id'] = $userId;
		return self::loadTrades($filters);
	}

	protected static function loadTrades(array $filters):Database_Result_Cached {
		$sql = "select
					ut.*, c.id `card:id`, c.name `card:name`, c.point `card:point`,
					r.id `recipient:id`, r.email `recipient:email`,
					s.id `sender:id`, s.email `sender:email`
				from `user_trades` ut
 				join `cards` c on c.id = ut.card_id
 				join `users` s on s.id = ut.sender_id
 				join `users` r on r.id = ut.recipient_id
 				where ".self::buildWhereExpression($filters)."
				order by ut.`id` desc;";
		return static::getDb()->query(Database::SELECT, $sql);
	}

	public static function loadHistoryUserTrades(int $userId, array $filters = []):Database_Result_Cached {
		return self::loadHistory($userId, $filters);
	}

	protected static function loadHistory(int $userId, array $filters):Database_Result_Cached {
		$sql = "select
					ut.*, c.id `card:id`, c.name `card:name`, c.point `card:point`,
					r.id `recipient:id`, r.email `recipient:email`,
					s.id `sender:id`, s.email `sender:email`
				from `user_trades` ut
 				join `cards` c on c.id = ut.card_id
 				join `users` s on s.id = ut.sender_id
 				join `users` r on r.id = ut.recipient_id
 				where (`sender_id` = ".$userId." or `recipient_id` = ".$userId.") and
 						".self::buildWhereExpression($filters)."
				order by ut.`id` desc;";
		return static::getDb()->query(Database::SELECT, $sql);
	}

}