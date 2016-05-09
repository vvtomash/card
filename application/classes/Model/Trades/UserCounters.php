<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 09.05.16
 * Time: 21:29
 */
class Model_Trades_UserCounters {

	const COUNTER_TRADE_COMPLETE = 'complete';
	const COUNTER_TRADE_SENDING = 'sending';
	const COUNTER_TRADE_PENDING = 'pending';
	const COUNTER_TRADE_OVERDUED = 'overdued';
	const COUNTER_TRADE_CLOSED = 'closed';
	const COUNTER_TRADE_REJECTED = 'rejected';
	const COUNTER_TRADE_DEBATE = 'debate';

	protected static $allowedCounters = [
		self::COUNTER_TRADE_COMPLETE,
		self::COUNTER_TRADE_SENDING,
		self::COUNTER_TRADE_PENDING,
		self::COUNTER_TRADE_OVERDUED,
		self::COUNTER_TRADE_CLOSED,
		self::COUNTER_TRADE_REJECTED,
		self::COUNTER_TRADE_REJECTED,
		self::COUNTER_TRADE_DEBATE,
	];

	public static function getOutCounters(int $userId, array $counters = [self::COUNTER_TRADE_COMPLETE, self::COUNTER_TRADE_SENDING, self::COUNTER_TRADE_PENDING, self::COUNTER_TRADE_OVERDUED]):array {
		$counters = array_intersect($counters, self::$allowedCounters);
		if (empty($counters)) {
			throw new Exception('Invalid params counters');
		}
		$rs = Model_Trades_Manager::userTradesCounters(['sender_id' => $userId, 'status' => $counters]);
		$result = array_fill_keys($counters, 0);
		foreach($rs as $row) {
			$result[$row['status']] = $row['cnt'];
		}
		return $result;
	}

	public static function getInCounters(int $userId, array $counters = [self::COUNTER_TRADE_COMPLETE, self::COUNTER_TRADE_SENDING, self::COUNTER_TRADE_PENDING]):array {
		$counters = array_intersect($counters, self::$allowedCounters);
		if (empty($counters)) {
			throw new Exception('Invalid params counters');
		}
		$rs = Model_Trades_Manager::userTradesCounters(['recipient_id' => $userId, 'status' => $counters]);
		$result = array_fill_keys($counters, 0);
		foreach($rs as $row) {
			$result[$row['status']] = $row['cnt'];
		}
		return $result;
	}
}