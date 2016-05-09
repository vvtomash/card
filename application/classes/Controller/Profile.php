<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile extends Controller_Index {

	public function action_index() {
		$this->pageName = 'Профиль пользователя';
		$this->activeMenu = 'profile';
		$profile = new Model_Profile(['user_id' => $this->currentUser->id]);
		$this->content = View::factory('pages/profile/edit')
			->set('profile', $profile)
			->render();

	}

	public function action_user() {
		$this->pageName = 'Профиль пользователя';
		$this->activeMenu = 'profile';
		$userId = $this->request->param('id');
		$profile = new Model_Profile(['user_id' => $userId]);
		if ($this->request->is_ajax()) {
			$this->content = array_merge(
				['username' => $profile->user->username],
				$profile->getPublicData()
			);
			return;
		}
		$this->content = View::factory('pages/profile/view')
			->set('profile', $profile)
			->render();
	}

	public function action_update() {
		try {
			$model = json_decode($this->request->body(), 1);
			$profile = new Model_Profile(['user_id' => $this->currentUser->id]);
			if (!$profile->loaded()) {
				$profile->set('user_id', $this->currentUser->id);
			}
			$profile->values([
				 'first_name' => Arr::get($model, 'first_name'),
				 'last_name' => Arr::get($model, 'last_name'),
				 'phone' => Arr::get($model, 'phone'),
				 'country' => Arr::get($model, 'country'),
				 'city' => Arr::get($model, 'city'),
				 'address' => Arr::get($model, 'address'),
				 'zip' => Arr::get($model, 'zip')
			 ])->save();
		} catch (ORM_Validation_Exception $e) {
			$this->errors[] = [
				'type' => 'validation',
				'messages' => $e->errors('models'),
			];
			return;
		}
		$this->content = $profile->get('id');
	}
}