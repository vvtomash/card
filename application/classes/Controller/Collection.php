<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Collection extends Controller_Index {

	use Controller_Trait_Pager;

	protected $pageName = 'Коллекция';

	public function action_index() {
		$this->activeMenu = '/collection';
		$types = Model_Cards_Manager::getCardTypes();
		$this->content = View::factory('pages/collection/main')
			->set('types', $types)
			->render();
	}
}