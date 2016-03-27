<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:53
 */
class Model_Trades_UserTradeEntity extends \ORM {
	protected $_table_name = 'user_trades';
	protected $_primary_key = 'id';

	protected $_belongs_to = [
		'card' => [
			'model' => 'Cards_CardEntity',
			'foreign_key' => 'card_id',
		],
		'recipient' => [
			'model' => 'User',
			'foreign_key' => 'recipient_id',
		],
		'sender' => [
			'model' => 'User',
			'foreign_key' => 'sender_id',
		]
	];
}