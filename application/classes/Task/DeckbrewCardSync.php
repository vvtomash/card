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
class Task_DeckbrewCardSync extends Task_Cron
{
	private $apiUrl = 'https://api.deckbrew.com/mtg/cards';

	private $lastPage = 1;
	private $countPerRequest = 100;



	public function __construct() {
		parent::__construct();
		$data = $this->getLastTask('main');
		$this->lastPage = Arr::get($data, 'last_page', 0);
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
			$maxPage = $this->lastPage + 100;
			while ($this->lastPage < $maxPage) {
				$this->updateTask('main', 'progress', ['last_page' => $this->lastPage]);
				$url = $this->apiUrl . ($this->lastPage > 1 ? '?page='.$this->lastPage : '');
				$result = json_decode(file_get_contents($url), 1);
				foreach($result as $row) {
					$card['deckbrew_id'] = Arr::get($row, 'id');
					$card['name'] = Arr::get($row, 'name');
					$card['url'] = Arr::get($row ,'url');
					$card['tcgplayer_url'] = Arr::get($row, 'store_url');
					$card['types'] = json_encode(Arr::get($row, 'types', []));
					$card['supertypes'] = json_encode(Arr::get($row, 'supertypes',[]));
					$card['subtypes'] = json_encode(Arr::get($row, 'subtypes',[]));
					$card['cmc'] = Arr::get($row, 'cmc');
					$card['cost'] = Arr::get($row, 'cost');
					$card['text'] = Arr::get($row, 'text');
					$card['power'] = Arr::get($row, 'power');
					$card['toughness'] = Arr::get($row, 'toughness');
					$card['formats'] = json_encode(Arr::get($row, 'formats',[]));
					foreach (Arr::get($row, 'editions',[]) as $edition) {
						$card['set'] = Arr::get($edition, 'set');
						$card['set_deckbrew_id'] = Arr::get($edition, 'set_id');
						$card['rarity'] = Arr::get($edition, 'rarity');
						$card['artist'] = Arr::get($edition, 'artist');
						$card['multiverse_id'] = Arr::get($edition, 'multiverse_id');
						$card['flavor'] = Arr::get($edition, 'flavor');
						$card['image'] = Arr::get($edition, 'image_url');
						Minion_CLI::write('Start card "' . $card['name']. '" save');
						try {
							$this->getDb()->begin();
							$cardId = $this->saveCard($card);
							$this->saveCardInfo($cardId, $card);
							$this->getDb()->commit();
							Minion_CLI::write('Card "' . $card['name']. '" is saved');
						} catch (Database_Exception $e) {
							Minion_CLI::write($e->getMessage());
							$this->getDb()->rollback();
						}
					}
				}
				if (count($result) < $this->countPerRequest) {
					break;
				}
				$this->lastPage++;
			}
		} catch (Throwable $e) {
			throw $e;
		} finally {
			$this->closeTask('main', ['last_page' => $this->lastPage]);
		}
		Minion_CLI::write('end sync...');
		return;
	}

	private function saveCard($card) {
		$name = $this->getDb()->escape($card['name']);
		$description = $this->getDb()->escape($card['text']);
		$img = $this->getDb()->escape($card['image']);
		$sql = "
			INSERT INTO `cards`
				(`name`, `description`, `img`, `point`)
			VALUES
				($name, $description, $img, 0);";
		list ($cardId, $cnt) = $this->getDb()->query(Database::INSERT, $sql);
		return $cardId;
	}

	private function saveCardInfo($cardId, $card) {

		$fields = implode(',' ,array_map(function($field) {return "`$field`";}, array_keys($card)));
		$values = implode(',' ,array_map(function($value) {return $this->getDb()->escape($value);}, array_values($card)));
		$sql = "
			INSERT INTO `card_info`
				(`card_id`, $fields)
			VALUES
				($cardId, $values);";
		$this->getDb()->query(Database::INSERT, $sql);
	}
}