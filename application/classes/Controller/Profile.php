<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile extends Controller_Index {

	public function action_index() {
		$this->pageName = 'Профиль пользователя';
		$this->activeMenu = 'profile';
		$this->content = View::factory('pages/profile')
			->set('profile', new Model_Profile($this->currentUser->id))
			->render();
	}
}