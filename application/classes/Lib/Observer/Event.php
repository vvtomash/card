<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 03.04.16
 * Time: 22:54
 */
class Event {

	protected $name = [];

	protected $data = [];

	protected $stop = false;

	public function __construct($name, $data = null) {
		$this->name = $name;
		$this->data = $data;
	}

	public function getName() {
		return $this->name;
	}

	public function getData() {
		return $this->data;
	}

	public function stop() {
		$this->stop = true;
	}
}