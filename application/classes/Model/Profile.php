<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 14.03.16
 * Time: 22:14
 */
class Model_Profile extends ORM {
	protected $_table_name = 'user_profile';
	protected $_primary_key = 'id';

	protected $_belongs_to = [
		'user' => [
			'model' => 'User',
			'foreign_key' => 'user_id',
		]
	];

}