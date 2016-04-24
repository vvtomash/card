<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Index {
	use Controller_Trait_Pager;

	protected $pageName = "Поиск карт";

	public function action_index() {
		$this->onPage = Model_Search::LIMIT;
		$cards = [];
		$count = 0;
		if ($searchText = $this->request->query('searchText')) {
			$cards = Model_Search::cardsByName($searchText, ($this->currentPage() - 1)*$this->onPage, $this->onPage);
			$count = Model_Search::countResult($searchText);
		}
		View::set_global('searchText', $searchText);
		$this->content = View::factory('pages/search/mainSearch')
			->set('cards', $cards)
			->set('searchCount', $count)
			->set('pager', $this->getPaginator('/search', $count, $this->request->query()))
			->render();
	}

	public function action_cards() {
		$searchText = $this->request->query('searchText');
		$this->content = array_map(
			function($card) {
				return array_intersect_key($card, array_flip(['id' ,'name']));
			},
			Model_Search::cardsByName($searchText)
		);
	}
}