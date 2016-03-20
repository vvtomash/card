<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Trades extends Controller_Index {

	public function action_send() {
		$this->pageName = 'Послать карту';
		$this->activeMenu = 'trades/send';
		$this->content = 'send';
	}

	public function action_sending() {
		$this->pageName = 'Отправляются';
		$this->activeMenu = 'trades/sending';
		$this->content = 'sending';
	}

	public function action_receiving() {
		$this->pageName = 'Ожидаются';
		$this->activeMenu = 'trades/receiving';
		$this->content = 'receiving';
	}

	public function action_history() {
		$this->pageName = 'История сделок';
		$this->activeMenu = 'trades/history';
		$this->content = 'история сделок';
	}

	public function action_partners() {
		$this->pageName = 'Партнеры';
		$this->activeMenu = 'trades/partners';
		$this->content = 'partners';
	}
}