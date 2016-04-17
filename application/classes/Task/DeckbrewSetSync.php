<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This is a scheduler from sync cards Deckbrew.
 *
 * It can accept the following options:
 *  - foo: this parameter does something. It is required.
 *  - bar: this parameter does something else. It should be numeric.
 *
 * @package    Kohana
 * @category   Helpers
 * @author     Kohana Team
 * @copyright  (c) 2009-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Task_DeckbrewSetSync extends Task_Cron
{
	private $apiUrl = 'https://api.deckbrew.com/mtg/sets';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * This is a demo task
	 *
	 * @return null
	 */
	protected function _execute(array $params)
	{
		$this->startTask();
		Minion_CLI::write('start sync...');
		try {
			$url = $this->apiUrl . ($this->lastPage > 1 ? '?page='.$this->lastPage : '');
			$result = json_decode(file_get_contents($url), 1);
			foreach($result as $row) {
				$set['deckbrew_id'] = Arr::get($row, 'id');
				$set['name'] = Arr::get($row, 'name');
				$set['border'] = Arr::get($row ,'border');
				$set['type'] = Arr::get($row, 'type');

				try {
					$this->saveSet($set);
				} catch (Database_Exception $e) {
					Minion_CLI::write($e->getMessage());
				}
			}
		} catch (Throwable $e) {
			throw $e;
		} finally {
			$this->closeTask('main');
		}
		Minion_CLI::write('end sync...');
		return;
	}

	private function saveSet($set) {
		$deckbrew_id = $this->getDb()->escape($set['deckbrew_id']);
		$name = $this->getDb()->escape($set['name']);
		$border = $this->getDb()->escape($set['border']);
		$type = $this->getDb()->escape($set['type']);
		$sql = "
			INSERT IGNORE `sets`
				(`deckbrew_id`, `name`, `border`, `type`)
			VALUES
				($deckbrew_id, $name, $border, $type);";
		return $this->getDb()->query(Database::INSERT, $sql);
	}
}