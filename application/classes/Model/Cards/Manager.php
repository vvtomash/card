<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:51
 */
class Model_Cards_Manager extends DBModel {

	public static function loadUserCards(int $userId):Database_Result_Cached {
		$sql = "select *, uc.id as id from `user_cards` uc
 				join `cards` c on c.id = uc.card_id
				where user_id = $userId";
		return static::getDb()->query(Database::SELECT, $sql);
	}

	public static function removeUserCard(int $userId, int $userCardId):bool {
		$sql = "delete from `user_cards` where user_id = $userId and id = $userCardId";
		return (bool)static::getDb()->query(Database::DELETE, $sql);
	}

	public static function addUserCard(int $userId, int $cardId):int {
		$sql = "insert into `user_cards` where user_id = $userId and card_id = $cardId";
		list($userCardId) = static::getDb()->query(Database::INSERT, $sql);
		return $userCardId;
	}
}