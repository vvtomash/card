<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Index {

	protected $pageName = "Поиск карт";

	public function action_index() {
		$cards = [];
		if ($searchText = $this->request->post('searchText')) {
			$cards = Model_Search::cardsByName($searchText);
		}
		View::set_global('searchText', $searchText);
		$this->content = View::factory('pages/search/mainSearch')
			->set('cards', $cards)
			->render();
	}

	public function action_cards() {
		$searchText = $this->request->post('searchText');
		$this->content = array_map(
			function($card) {
				return array_intersect_key($card, array_flip(['id' ,'name']));
			},
			Model_Search::cardsByName($searchText)
		);
	}
}