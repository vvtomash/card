<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:53
 */
class Model_Cards_UserWantEntity extends \ORM {
	protected $_table_name = 'user_wants';
	protected $_primary_key = 'id';

	protected $_belongs_to = [
		'card' => [
			'model' => 'Cards_CardEntity',
			'foreign_key' => 'card_id',
		],
		'card_info' => [
			'model' => 'Cards_CardInfoEntity',
			'foreign_key' => 'card_id',
		],
	];
}