<?php defined('SYSPATH') or die('No direct script access.');

trait Controller_Trait_Pager {

	protected $onPage = 5;
	protected $currentPage = 1;

	public function currentPage() {
		return max($this->request->param('page'), 1);
	}

	/**
	 * @return View
	 */
	protected function getPaginator($url, $totalCount, array $params = []) {
		return View::factory('elements/pager')
			->set('pager', new Pager($url, $totalCount, $this->currentPage(), $this->onPage, $params));
	}
}