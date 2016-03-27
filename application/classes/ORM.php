<?php defined('SYSPATH') OR die('No direct script access.');

class ORM extends Kohana_ORM {

	public function __construct($id = null, array $data = []) {
		if ($id !== null) {
			parent::__construct($id);
		} elseif (!empty($data[$this->_primary_key])) {
			parent::__construct();
			$this->_load_values($data);
		} else {
			parent::__construct();
		}
	}
}