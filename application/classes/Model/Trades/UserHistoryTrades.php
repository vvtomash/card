<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Trades_UserHistoryTrades extends \Collection {

	protected $entities = [];
	protected $userId;

	private function __construct($userId) {
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load():Model_Trades_UserHistoryTrades {
		foreach (Model_Trades_Manager::loadHistoryUserTrades($this->userId, ['status' => ['closed', 'complete', 'rejected']]) as $trade) {
			Debug::vars($trade);
			$this->entities[$trade['id']] = new Model_Trades_UserTradeEntity(null, $trade);
		}
		return $this;
	}

	public static function instance(int $userId):Model_Trades_UserHistoryTrades {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new self($userId);
		}
		return self::$instances[$userId];
	}
}

class TradeCreatedFailException extends Kohana_Exception {};