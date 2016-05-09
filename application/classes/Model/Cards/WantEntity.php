<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:53
 */
class Model_Cards_WantEntity extends \ORM {
	protected $_table_name = 'user_wants';
	protected $_primary_key = 'id';

	public $canSend = false;

	protected $_belongs_to = [
		'card' => [
			'model' => 'Cards_CardEntity',
			'foreign_key' => 'card_id',
		],
		'card_info' => [
			'model' => 'Cards_CardInfoEntity',
			'foreign_key' => 'card_id',
		],
		'user' => [
			'model' => 'User',
			'foreign_key' => 'user_id',
		]
	];

	/**
	 * @param boolean $canSend
	 * @return static
	 */
	public function setCanSend($canSend)
	{
		$this->canSend = (bool)$canSend;
		return $this;
	}

}