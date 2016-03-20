<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Index {

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