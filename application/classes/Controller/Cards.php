<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cards extends Controller_Index {
	use Controller_Trait_Pager;

	protected $pageName = 'Продам';

	public function action_haves() {
		$this->activeMenu = 'cards/haves';
		$userCards = Model_Cards_UserCards::instance($this->currentUser->id)
			->load($this->onPage, ($this->currentPage() - 1)*$this->onPage);
		$totalInfo = $userCards->totalInfo();
		$this->content = View::factory('pages/cards/userCards')
			->set('userCards', $userCards)
			->set('totalInfo', $totalInfo)
			->set('pager', $this->getPaginator('/cards/haves', $totalInfo['count']))
			->render();
	}

	public function action_nextHaves() {
		$count = $this->request->post('count');
		$userCards = Model_Cards_UserCards::instance($this->currentUser->id)
			->load($count, ($this->currentPage())*$this->onPage - $count);
		$this->content = $userCards->as_array();
	}

	public function action_wants() {
		$this->pageName = 'Куплю';
		$this->activeMenu = 'cards/wants';
		if (!Model_Cards_UserWants::checkAvailableTrades($this->currentUser->id)) {
			$this->content = View::factory('pages/cards/userWantsDenied');
			return;
		}
		$userWants = Model_Cards_UserWants::instance($this->currentUser->id)
			->load($this->onPage, ($this->currentPage() - 1)*$this->onPage);
		$totalInfo = $userWants->totalInfo();
		$this->content = View::factory('pages/cards/userWants')
			->set('userWants', $userWants)
			->set('totalInfo', $totalInfo)
			->set('pager', $this->getPaginator('/cards/wants', $totalInfo['count']))
			->render();
	}

	public function action_nextWants() {
		$count = $this->request->post('count');
		$userCards = Model_Cards_UserWants::instance($this->currentUser->id)
			->load($count, ($this->currentPage())*$this->onPage - $count);
		$this->content = $userCards->as_array();
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
		$this->content = [
			'id' => $userCard->id,
			'name' => $userCard->card->name,
			'point' => $userCard->card->point,
			'added_timestamp' => $userCard->added_timestamp,
		];
	}

	public function action_removeWant() {
		$id = $this->request->post('id');
		if (empty($id)) {
			$this->errors[] = 'Empty card id';
			return;
		}
		if (!Model_Cards_UserWants::instance($this->currentUser->id)->remove($id)) {
			$this->errors[] = 'Failed removing';
			return;
		}
		$this->content = true;
	}

	public function action_addWant() {
		$id = $this->request->post('id');
		if (empty($id)) {
			$this->errors[] = 'Empty card id';
			return;
		}

		if (($userCard = Model_Cards_UserWants::instance($this->currentUser->id)->add($id)) === null) {
			$this->errors[] = 'Failed adding';
			return;
		}
		$this->content = [
			'id' => $userCard->id,
			'set' => $userCard->card_info->set_code,
			'name' => $userCard->card->name,
			'point' => $userCard->card->point,
			'added_timestamp' => $userCard->added_timestamp,
		];
	}

	public function action_change() {
		$model = json_decode($this->request->body(), 1);
		if (!empty($model)) {
			$this->content = [];
			$card = \ORM::factory('Cards_UserCardEntity', $model['id']);
			if (isset($model['status'])) {
				$card->status = $model['status'];
				$this->content['status'] = $card->status;
			}
			if (isset($model['condition'])) {
				$card->condition = $model['condition'];
				$this->content['condition'] = $card->condition;
				$this->content['point'] = $card->getPoint();
			}
			$card->save();
			return $this->content;
		}
		throw new \Exception('Failed change');
	}

	public function action_changeWant() {
		$model = json_decode($this->request->body(), 1);
		if (!empty($model)) {
			$this->content = [];
			$want = \ORM::factory('Cards_UserWantEntity', $model['id']);
			if (isset($model['status'])) {
				$want->status = $model['status'];
				$this->content['status'] = $want->status;
			}
			$want->save();
			return $this->content;
		}
		throw new \Exception('Failed change');
	}
}