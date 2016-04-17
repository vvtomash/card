<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 03.04.16
 * Time: 22:54
 */
class UserCollection extends Collection {

	protected $userId;

	private static $instances = [];

	private function __construct($userId) {
		$this->userId = $userId;
	}

	public static function instance(int $userId):UserCollection {
		if (empty(self::$instances[$userId])) {
			self::$instances[$userId] = new static($userId);
		}
		return self::$instances[$userId];
	}
}