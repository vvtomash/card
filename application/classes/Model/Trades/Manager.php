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

	public static function getSuitableUserCard(int $userId, int $cardId): array {
		$sql = "select uc.*, c.*, uc.id as id from `user_cards` uc
 				join `cards` c on c.id = uc.card_id
 				left join `user_trades` ut on ut.user_card_id = uc.id
				where
					uc.`user_id` = $userId
					and uc.`card_id` = $cardId
					and ut.status is null or ut.status not in ('pending', 'sending', 'complete')
				order by uc.`id` desc
				limit 1";
		return (array)static::getDb()->query(Database::SELECT, $sql)->current();
	}

	public static function getSuitableWantCard(int $cardId): array {
		$sql = "select uw.*, c.*, uw.id as id from `user_wants` uw
 				join `cards` c on c.id = uw.card_id
				left join `user_trades` ut on ut.user_want_id = uw.id
				where
					 uw.`card_id` = $cardId and uw.`status` = 'active'
					 and ut.status is null or ut.status not in ('pending', 'sending', 'complete')
				order by uw.`id` desc
				limit 1";
		return (array)static::getDb()->query(Database::SELECT, $sql)->current();
	}

	public static function closeOverduedTrades(int $userId) {
		$sql = "update `user_trades`
				  set `status` = 'overdued'
				  where
					  sender_id = $userId
					  and `status` = 'pending'
					  and unix_timestamp() - unix_timestamp(`time_create`) < ".Model_Trades_UserTradeEntity::TIME_CONFIRMATION_SEND;
		static::getDb()->query(Database::UPDATE, $sql);
	}

	public static function userTradesCounters(array $filters = []): Database_Result_Cached {
		$sql = "select `status`, count(*) `cnt`
				from `user_trades`
 				where ".self::buildWhereExpression($filters)."
				group by `status`";
		return static::getDb()->query(Database::SELECT, $sql);
	}
}