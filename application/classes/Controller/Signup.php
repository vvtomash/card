<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signup extends Controller_Index {
	public function action_index() {
		$this->pageName = '';
		if ($this->request->method() === 'POST') {
			if ($this->signup()) {
				$this->redirect('/');
			};
		}
		$this->content = View::factory('forms/signup')
			->set('email', $this->request->post('email'))
			->render();
	}

	protected function signup() {
		try {
			if ($user = Model::factory('User')->create_user($this->request->post(), ['email', 'password'])) {
				var_dump($user->add('roles', ORM::factory('Role', ['name' => 'login'])));
				Auth::instance()->login($user->email, $user->password, true);
				return true;
			}
		} catch (ORM_Validation_Exception $e) {
			print_r($e->errors('models'));
		}
		return false;
	}
}