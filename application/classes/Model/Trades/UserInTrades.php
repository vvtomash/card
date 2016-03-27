<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Trades_UserInTrades extends \Collection {

	protected $entities = [];
	protected $userId;

	private function __construct($userId) {
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load():Model_Trades_UserInTrades {

		foreach (Model_Trades_Manager::loadInUserTrades($this->userId, ['status' => ['pending', 'debate']]) as $trade) {
			Debug::vars($trade);
			$this->entities[$trade['id']] = new Model_Trades_UserTradeEntity(null, $trade);
		}
		return $this;
	}

	public static function instance(int $userId):Model_Trades_UserInTrades {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new self($userId);
		}
		return self::$instances[$userId];
	}

	public function completeTrade(int $tradeId):Model_Trades_UserTradeEntity {
		$trade = new Model_Trades_UserTradeEntity($tradeId);
		if ($trade->recipient_id == $this->userId) {
			$trade->values([
				'status' => 'complete',
				'time_closed' => date('Y-m-d H:i:s')
			])->save();
			return $trade;
		}
		throw new TradeInNotFoundException;
	}
}

class TradeInNotFoundException extends Kohana_Exception {};