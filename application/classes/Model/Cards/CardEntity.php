<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:53
 */
class Model_Cards_CardEntity extends \ORM {
	protected $_table_name = 'cards';
	protected $_primary_key = 'id';

	protected $_belongs_to = [
		'card_info' => [
			'model' => 'Cards_CardInfoEntity',
			'foreign_key' => 'card_id',
		]
	];

}