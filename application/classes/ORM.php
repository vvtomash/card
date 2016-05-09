<?php defined('SYSPATH') OR die('No direct script access.');

class ORM extends Kohana_ORM {

	protected $builded = false;

	public function __construct($id = null, array $data = []) {
		if ($id !== null) {
			parent::__construct($id);
		} elseif (!empty($data[$this->_primary_key])) {
			parent::__construct();
			$this->_load_values($data);
		} else {
			parent::__construct();
		}
		$this->builded = true;
	}

	public function __set($column, $value) {
		parent::__set($column, $value);
		if (!$this->builded) {
			return;
		}
		\Observer::trigger(new \Event(get_called_class().':change:'.$column, ['model' =>$this]), [$column => $value]);
	}
}