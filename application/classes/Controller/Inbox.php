<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Inbox extends Controller_Index {
	use Controller_Trait_Pager;

	protected $pageName = 'Сообщения';

	public function action_index() {
		$this->activeMenu = 'messages';
		$userMessages = Model_Messages_Inbox::instance($this->currentUser->id)
			->load($this->onPage, ($this->currentPage() - 1)*$this->onPage);
		$this->content = View::factory('pages/messages/inbox')
			->set('messages', $userMessages)
			->set('counters', $userMessages->getCounters())
			->set('pager', $this->getPaginator('/inbox', $userMessages->getCount()))
			->render();
	}

	public function action_removeMessage() {
		$id = $this->request->post('id');
		Model_Messages_Inbox::markAs($id, 'deleted');
		$this->content = true;
	}

	public function action_readMessage() {
		$id = $this->request->post('id');
		Model_Messages_Inbox::markAs($id, 'read');
		$this->content = true;
	}

	public function action_nextMessage() {
		$count = $this->request->post('count');
		$userMessages = Model_Messages_Inbox::instance($this->currentUser->id)
			->load($count, ($this->currentPage())*$this->onPage - $count);
		$this->content = $userMessages->as_array();
	}
}