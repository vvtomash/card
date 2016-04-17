<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:51
 */
class Model_Cards_Manager extends DBModel {

	public static function loadUserCards(int $userId, int $limit, int $offset = 0):Database_Result_Cached {
		$sql = "select *, uc.id as id from `user_cards` uc
 				join `cards` c on c.id = uc.card_id
				where `user_id` = $userId
				order by uc.`id` desc
				limit $offset, $limit;";
		return static::getDb()->query(Database::SELECT, $sql);
	}

	public static function totalInfoUserCards(int $userId):array {
		$sql = "select count(*) `count`, sum(point) points
				from `user_cards` uc
				join `cards` c on c.id = uc.card_id
				where `user_id` = $userId";
		return static::getDb()->query(Database::SELECT, $sql)->current();
	}

	public static function loadUserWants(int $userId, int $limit, int $offset = 0):Database_Result_Cached {
		$sql = "select *, uc.id as id from `user_wants` uc
 				join `cards` c on c.id = uc.card_id
				where `user_id` = $userId
				order by uc.`id` desc
				limit $offset, $limit;";
		return static::getDb()->query(Database::SELECT, $sql);
	}


	public static function totalInfoUserWants (int $userId):array {
		$sql = "select count(*) `count`, sum(point) points
				from `user_wants` uw
				join `cards` c on c.id = uw.card_id
				where `user_id` = $userId";
		return static::getDb()->query(Database::SELECT, $sql)->current();
	}

	public static function loadAllWants(array $filters = []):Database_Result_Cached {
		$sql = "select uc.*, c.id `card:id`, c.name `card:name`, c.point `card:point`, u.id `user:id`, u.email `user:email`
				from `user_wants` uc
 				join `cards` c on c.id = uc.card_id
 				join `users` u on u.id = uc.user_id
 				where ".self::buildWhereExpression($filters)."
				order by uc.`id` desc;";
		return static::getDb()->query(Database::SELECT, $sql);
	}

	public static function removeUserCard(int $userId, int $userCardId):bool {
		$sql = "delete from `user_cards` where user_id = $userId and id = $userCardId";
		return (bool)static::getDb()->query(Database::DELETE, $sql);
	}

	public static function removeUserWant(int $userId, int $userCardId):bool {
		$sql = "delete from `user_wants` where user_id = $userId and id = $userCardId";
		return (bool)static::getDb()->query(Database::DELETE, $sql);
	}

	public static function addUserCard(int $userId, int $cardId):int {
		$sql = "insert into `user_cards` where user_id = $userId and card_id = $cardId";
		list($userCardId) = static::getDb()->query(Database::INSERT, $sql);
		return $userCardId;
	}

	public static function addUserWant(int $userId, int $cardId):int {
		$sql = "insert into `user_wants` where user_id = $userId and card_id = $cardId";
		list($userCardId) = static::getDb()->query(Database::INSERT, $sql);
		return $userCardId;
	}
}