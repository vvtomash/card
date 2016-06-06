<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Collection extends Controller_Index {

	use Controller_Trait_Pager;

	protected $pageName = 'Коллекция';

	public function action_index() {
		$this->activeMenu = '/collection';
		$types = Model_Cards_Manager::getCardTypes();
		$colors = Model_Cards_Manager::getCardColors();
		$rarities = Model_Cards_Manager::getCardRarities();
		$expansions = Model_Expansions_Manager::loadExpansions();
		$this->content = View::factory('pages/collection/main')
			->set('expansions', $expansions)
			->set('rarities', $rarities)
			->set('colors', $colors)
			->set('types', $types)
			->render();
	}

	public function action_search() {
		$filters = json_decode($this->request->body(), 1);
		$search = Model_Collection_UserCollection::instance($this->currentUser->id);
		foreach($filters as $filter => $val) {
			$search->setFilter($filter, $val);
		}
		$result = $search->load($this->onPage);
		$this->content = $result;
	}
}