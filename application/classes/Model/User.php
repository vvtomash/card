<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User {
	protected $_table_name = 'users';

	protected $_belongs_to = [
		'profile' => [
			'model' => 'Model_Profile',
			'foreign_key' => 'user_id',
		]
	];

	public function rules() {
		return [
			'password' => [
				['not_empty']
			],
			'email' => [
				['not_empty'],
				['email'],
				[
					[$this, 'unique'],
					['email', ':value']
				]
			],
		];
	}
}