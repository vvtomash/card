<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Index {
	public function action_index() {
		if (Auth::instance()->logged_in('login')) {
			$this->redirect('/');
		}
		$email = $this->request->post('email');
		$password = $this->request->post('password');
		try {
			if (Auth::instance()->login($email, $password, true)) {
				return $this->redirect('/');
			}
		} catch (Kohana_Auth_Exception $e) {
			$this->errors = [$e->getMessage()];
		}
		$this->content = View::factory('forms/login')
			->set('errors', $this->errors )
			->set('email', $email)
			->render();
	}

	public function action_logout() {
		Auth::instance()->logout(true);
		$this->redirect('/');
	}
}