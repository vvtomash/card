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
		'card_info' => [
			'model' => 'Cards_CardInfoEntity',
			'foreign_key' => 'card_id',
		]
	];

	public function getPoint():float {
		return $this->card->point * $this->getCardConditionValue();
	}

	private function getCardConditionValue() {
		$card = \Kohana::$config->load('app')->get('card');
		if (isset($card['conditions'][$this->condition])) {
			$condition = $card['conditions'][$this->condition];
			return $condition['value'];
		}
		return 1;
	}
}