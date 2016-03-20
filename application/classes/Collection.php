
<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 19:17
 */
class Collection implements ArrayAccess, Iterator {
	protected $entities = [];

	public function offsetExists($offset) {
		return isset($this->entities[$offset]);
	}

	public function offsetGet($offset) {
		return $this->entities[$offset];
	}

	public function offsetSet($offset, $value) {
		return $this->entities[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->entities[$offset]);
	}

	public function rewind() {
		reset($this->entities);
	}

	public function current() {
		return current($this->entities);
	}

	public function key() {
		return key($this->entities);
	}

	public function next() {
		next($this->entities);
	}

	public function valid() {
		return key($this->entities) !== null;
	}

	public function as_array() {
		$res = [];
		foreach($this->entities as $entity) {
			$res[] = $entity->as_array();
		}
		return $res;
	}
}