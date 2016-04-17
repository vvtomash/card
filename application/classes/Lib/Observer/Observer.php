<?php
/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 03.04.16
 * Time: 22:54
 */
class Observer {

	protected static $events = [];

	protected static $handlers = [];

	/**
	 * @var static
	 */
	protected static $instance;

	private function __construct() {}

	public static function instance():Observer {
		if (empty(self::$instance)) {
			self::$instance = new static();
		}
		return self::$instance;
	}

	public static function bind(string $eventName, $handler, bool $persist = true) {
		static::$handlers[$eventName][] = [
			'callback' => $handler,
			'persist' => $persist
		];
	}

	public static function trigger(Event $event, array $data = []) {
		if (empty (static::$handlers[$event->getName()])) return;
		foreach (static::$handlers[$event->getName()] as $key => $handler) {
			call_user_func_array($handler['callback'], [$event, $data]);
			if (!$handler['persist']) {
				unset(static::$handlers[$event->getName()][$key]);
			}
			if ($event->stop()) {
				break;
			}
		}
	}
}