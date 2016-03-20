<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cards extends Controller_Index {
	protected $pageName = 'Мои карты';
	public function action_haves() {
		$this->activeMenu = 'cards/haves';
		$userCards = Model_Cards_UserCards::instance($this->currentUser->id)->load();
		$this->content = View::factory('pages/cards/userCards')
			->set('userCards', $userCards)
			->render();
	}

	public function action_wants() {
		$this->activeMenu = 'cards/wants';
		$this->content = 'Wants cards';
	}

	public function action_imports() {
		$this->activeMenu = 'cards/imports';
		$this->content = 'Imports cards';
	}

	public function action_remove() {
		$id = $this->request->post('id');
		if (empty($id)) {
			$this->errors[] = 'Empty card id';
			return;
		}
		if (!Model_Cards_UserCards::instance($this->currentUser->id)->remove($id)) {
			$this->errors[] = 'Failed removing';
			return;
		}
		$this->content = true;
	}

	public function action_add() {
		$id = $this->request->post('id');
		if (empty($id)) {
			$this->errors[] = 'Empty card id';
			return;
		}

		if (($userCard = Model_Cards_UserCards::instance($this->currentUser->id)->add($id)) === null) {
			$this->errors[] = 'Failed adding';
			return;
		}
		$card = new Model_Cards_CardEntity(1);
		$this->content = [
			'id' => $userCard->id,
			'name' => $userCard->card->name,
			'point' => $userCard->point,
			'added_timestamp' => $userCard->added_timestamp,
		];
	}
}