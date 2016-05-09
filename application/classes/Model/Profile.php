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

	protected $emptyFields = [];
	protected $needFieldsForTrade = [];

	protected $_belongs_to = [
		'user' => [
			'model' => 'User',
			'foreign_key' => 'user_id',
		]
	];

	protected $publicFields = [
		'first_name', 'last_name', 'address', 'country', 'city', 'zip_code'
	];

	public function rules() {
		return [
			'phone' => [
				['regex', [':value', '/^\+\d{3}\(\d{2}\)\d{3}-\d{2}-\d{2}$/']],
			],
		];
	}

	public function checkFullness(): bool {
		$needFields = ['first_name', 'last_name', 'address', 'city', 'country', 'phone'];
		$result = true;
		foreach ($needFields as $field) {
			if (empty($this->_object[$field])) {
				$this->emptyFields[] = $field;
				$result = false;
			}
		}
		return $result;
	}

	public function save(Validation $validation = null) {
		$result = parent::save($validation);
		Observer::trigger(new Event('Profile:Updated', $this));
		return $result;
	}

	public function getPublicData() {
		return array_intersect_key($this->_object, array_flip($this->publicFields));
	}
}