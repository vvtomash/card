<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User {
	protected $_table_name = 'users';

	/**
	 * Rules for the user model. Because the password is _always_ a hash
	 * when it's set,you need to run an additional not_empty rule in your controller
	 * to make sure you didn't hash an empty string. The password rules
	 * should be enforced outside the model or with a model helper method.
	 *
	 * @return array Rules
	 */
	public function rules()
	{
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