<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Trades_UserOutTrades extends \Collection {

	protected $entities = [];
	protected $userId;

	private function __construct($userId) {
		$this->userId = $userId;
	}

	private static $instances = [];

	public function load():Model_Trades_UserOutTrades {
		foreach (Model_Trades_Manager::loadOutUserTrades($this->userId, ['status' => ['sending', 'pending', 'debate']]) as $trade) {
			$this->entities[$trade['id']] = new Model_Trades_UserTradeEntity(null, $trade);
		}
		return $this;
	}

	public static function instance(int $userId):Model_Trades_UserOutTrades {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new self($userId);
		}
		return self::$instances[$userId];
	}

	public function startTrade(int $wantId):Model_Trades_UserTradeEntity {
		$wantCard = new Model_Cards_UserWantEntity($wantId);
		$suitableWantCard = new Model_Cards_UserWantEntity(
			null, Model_Trades_Manager::getSuitableWantCard($wantCard->card_id)
		);
		if ($suitableWantCard->card_id !== $wantCard->card_id) {
			throw new TradeCreatedFailException('Trade can not start with this card');
		}
		$userCard = new Model_Cards_UserCardEntity(
			null, Model_Trades_Manager::getSuitableUserCard($this->userId, $wantCard->card_id)
		);
		if (empty($userCard->card_id)) {
			throw new TradeCreatedFailException('You have not got suitable card for the trade');
		}
		$userTrade = new Model_Trades_UserTradeEntity();
		$userTrade->sender_id = $this->userId;
		$userTrade->user_want_id = $wantCard->id;
		$userTrade->user_card_id = $userCard->id;
		$userTrade->recipient_id = $wantCard->user_id;
		$userTrade->card_id = $wantCard->card_id;
		if ($userTrade->save()) {
			return $userTrade;
		}
		throw new TradeCreatedFailException;
	}
}

class TradeCreatedFailException extends Kohana_Exception {};