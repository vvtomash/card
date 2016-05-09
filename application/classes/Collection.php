<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 19:17
 */
class Collection implements ArrayAccess, Iterator {
	protected $entities = [];
	protected $ids = [];

	public function offsetExists($offset) {
		return isset($this->entities[$offset]);
	}

	public function offsetGet($offset) {
		return $this->entities[$offset];
	}

	public function offsetSet($offset, $value) {
		if (isset($value['id'])) {
			$this->ids[$value['id']] = $offset;
		};
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

	public function get($id) {
		if (isset($this->ids[$id])) {
			return $this->entities[$this->ids[$id]];
		}
		throw new Exception('Could not be found by id');
	}

	public function find($field, $value, $strict = false) {
		foreach ($this->entities as $entity) {
			if (is_array($entity) && !isset($entity[$field]) || is_object($entity) && !isset($entity->{$field})) {
				throw new Exception('Could not be found by id');
			}
			if (is_array($entity) && isset($entity[$field])) {
				$actualValue = $entity[$field];
			} else if (is_object($entity) && isset($entity->{$field})) {
				$actualValue = $entity->{$field};
			} else {
				continue;
			}
			if ($strict && $actualValue === $value) {
				return $entity;
			} elseif (!$strict && $actualValue == $value) {
				return $entity;
			}
		}
	}
}