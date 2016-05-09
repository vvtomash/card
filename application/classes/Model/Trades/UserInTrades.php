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
		Observer::bind('Trade:Complete', ['Model_Trades_UserInTrades', 'onCompleteTrade']);
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load():Model_Trades_UserInTrades {
		foreach (Model_Trades_Manager::loadInUserTrades($this->userId, ['status' => ['pending', 'debate']]) as $trade) {
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
			\Observer::trigger(new Event('Trade:Complete', $trade->as_array()));
			return $trade;
		}
		throw new TradeInNotFoundException;
	}

	public static function onCompleteTrade(Event $event) {
		$trade = $event->getData();
		$sender = Model::factory('User', $trade['sender_id']);
		Model_Messages_Inbox::send(
			0,
			$trade['sender_id'],
			'Trade complete successful',
			sprintf('User %s has confirmed shipping of the card', $sender->username)
		);
	}
}

class TradeInNotFoundException extends Kohana_Exception {};