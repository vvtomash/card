<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:53
 */
class Model_Messages_UserMessageEntity extends \ORM {
	protected $_table_name = 'user_messages';
	protected $_primary_key = 'id';

	protected $_belongs_to = [
		'user' => [
			'model' => 'User',
			'foreign_key' => 'to_id',
		],
		'author' => [
			'model' => 'User',
			'foreign_key' => 'from_id',
		]
	];
}