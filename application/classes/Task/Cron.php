<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 17.04.16
 * Time: 20:34
 */
abstract class Task_Cron extends Minion_Task {
	/**
	 * @var Database_PDO
	 */
	private $db;

	/**
	 * @return Database|Database_PDO
	 * @throws Kohana_Exception
	 */
	protected function getDb() {
		if (empty($this->db)) {
			$this->db = Database_PDO::instance();
		}
		return $this->db;
	}


	private $logIds = [];

	protected function getTaskName($name = 'main') {
		return get_called_class().".$name";
	}
	protected function startTask($name = 'main') {
		$taskName = $this->getDb()->escape($this->getTaskName($name));
		list($this->logIds[$this->getTaskName($name)], $cnt) = $this->getDb()->query(Database::INSERT, "insert into task_log (`name`) values ($taskName)");
		if (empty($this->logIds[$this->getTaskName($name)])) {
			throw new Exception('Cant start task');
		}
	}

	protected function updateTask($name = 'main', $status, array $data = []) {
		if (!empty($this->logIds[$this->getTaskName($name)])) {
			$update = '';
			if (!empty($status)) {
				$update[] = '`state` = '.$this->getDb()->escape($status);
			}
			if (!empty($data)) {
				$update[] = '`data` = '.$this->getDb()->escape(json_encode($data));
			}
			if (empty($update)) {
				return;
			}
			$this->getDb()->query(
				Database::UPDATE,
				"update task_log set ".implode(',', $update). "where id = ".$this->logIds[$this->getTaskName($name)]
			);
		}
	}

	protected function failTask($name = 'main', $error) {
		$this->updateTask($name, 'failed', ['error' => $error]);
	}

	protected function closeTask($name, array $data = []) {
		$this->updateTask($name, 'success', $data);
	}

	protected function getLastTask($name, $state = null) {
		$taskName = $this->getDb()->escape($this->getTaskName($name));
		$whereState = '';
		if (!empty($state)) {
			$whereState = 'AND `state` = ' . $this->getDb()->escape($state);
		}
		$rs = $this->getDb()->query(
			Database::SELECT,
			"SELECT `data` FROM task_log WHERE `name` = $taskName $whereState ORDER BY `last_exec_time` DESC LIMIT 1"
		);
		if ($data = Arr::get(Arr::get($rs->as_array(), 0, []), 'data')) {
			return json_decode($data, 1);
		}
		return [];
	}
}