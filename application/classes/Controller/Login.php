<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Index {
	public function action_index() {
		$email = $this->request->post('email');
		$password = $this->request->post('password');
		if (Auth::instance()->login($email, $password, true)) {
			return $this->redirect('/');
		}
		$this->content = View::factory('forms/login')->render();
	}

	public function action_logout() {
		Auth::instance()->logout(true);
		$this->redirect('/');
	}
}