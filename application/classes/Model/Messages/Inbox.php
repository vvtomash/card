<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 12.03.16
 * Time: 17:50
 */
class Model_Messages_Inbox extends \UserCollection {

	protected $entities = [];

	public function load(int $limit, int $offset = 0):Model_Messages_Inbox {
		foreach (Model_Messages_Manager::loadUserMessages($this->userId, ['status' => ['new', 'read']], $limit, $offset) as $message) {
			$this->entities[$message['id']] = new Model_Messages_UserMessageEntity(null, $message);
		}
		return $this;
	}

	public function getCount():int {
		return Model_Messages_Manager::getCountMessages($this->userId, ['status' => ['new', 'read']]);
	}

	public function getCounters():array {
		$statuses = ['new', 'read'];
		$result = [];
		$counters = Model_Messages_Manager::getCountersMessages($this->userId, ['status' => $statuses]);
		foreach ($counters as $counter) {
			$result[$counter['status']] = $counter['count'];
		}
		return array_merge($result, array_combine($statuses, [0, 0]));
	}

	public function getCountUnread():int {
		return Model_Messages_Manager::getCountMessages($this->userId, ['status' => ['new']]);
	}

	public static function markAs(int $messageId, $status) {
		$message = new Model_Messages_UserMessageEntity($messageId);
		if ($message->status  === 'new' && $status === 'read') {
			$message->set('read_timestamp', date('Y-m-d H:i:s'));
		}
		$message->set('status', $status);
		$message->save();
	}

	public static function send(int $fromId, int $toId, string $subject, string $text) {
		$message = new Model_Messages_UserMessageEntity();
		$message->set('from_id', $fromId);
		$message->set('to_id', $toId);
		$message->set('subject', $subject);
		$message->set('body', $text);
		$message->save();
	}
}