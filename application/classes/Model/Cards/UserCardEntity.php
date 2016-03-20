<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:53
 */
class Model_Cards_UserCardEntity extends \ORM {
	protected $_table_name = 'user_cards';
	protected $_primary_key = 'id';

	protected $_belongs_to = [
		'card' => [
			'model' => 'Cards_CardEntity',
			'foreign_key' => 'card_id',
		],
	];

	public function __construct($id = null, array $data = []) {
		if ($id !== null) {
			parent::__construct($id);
		} elseif (!empty($data[$this->_primary_key])) {
			parent::__construct($data[$this->_primary_key]);
			$this->_load_values($data);
		} else {
			parent::__construct();
		}
	}
}