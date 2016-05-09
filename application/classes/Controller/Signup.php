<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signup extends Controller_Index {
	public function action_index() {
		$this->pageName = '';
		if (Auth::instance()->logged_in('login')) {
			$this->redirect('/');
		}
		if ($this->request->method() === 'POST') {
			if ($this->signup()) {
				$this->redirect('/');
			};
		}
		$this->content = View::factory('forms/signup')
			->set('errors', $this->errors)
			->set('email', $this->request->post('email'))
			->render();
	}

	protected function signup() {
		try {
			$userData = [
				'email' => $this->request->post('email'),
				'password' => $this->request->post('password'),
				'username' => $this->getUserName($this->request->post('email')),
				'password_confirm' => $this->request->post('password_confirm'),
			];
			if ($user = Model::factory('User')->create_user($userData, ['email', 'password', 'username'])) {
				$user->add('roles', ORM::factory('Role', ['name' => 'login']));
				Auth::instance()->force_login($user->email);
				return true;
			}
		} catch (ORM_Validation_Exception $e) {
			$errors = $e->errors('models');
			$external = Arr::get($errors, '_external', false);
			unset($errors['_external']);
			$this->errors = Arr::merge($errors, ($external ? $external : array()));
		}
		return false;
	}

	private function getUserName($email) {
		$data = explode('@', $email);
		return $data[0];
	}
}