<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Index {
	protected $pageName = 'Домашняя';
	protected $activeMenu = 'home';


	public function action_index() {
		$this->content = 'Дом';
	}
}