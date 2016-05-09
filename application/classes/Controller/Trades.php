<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Trades extends Controller_Index {

	public function action_send() {
		$this->pageName = 'Послать карту';
		$this->activeMenu = 'trades/send';
		$wants = Model_Cards_Wants::instance()
			->setFilter([
				'user_id:not' => $this->currentUser->id
			])
			->load();
		$this->content = View::factory('pages/trades/wants')
			->set('wants', $wants)
			->render();
	}

	public function action_card() {
		$this->pageName = 'Послать карту';
		$userCardId = $this->request->param('id');
		$userCard = new Model_Cards_UserCardEntity($userCardId);

		$wants = Model_Cards_Wants::instance()->
			setFilter([
				  'user_id:not' => $this->currentUser->id,
				  'card_id' => $userCard->card_id,
		  	])
			->load()
			->applyUserCards([$userCard->card_id]);
		$counters = Model_Trades_UserCounters::getOutCounters(
			$this->currentUser->id
		);
		$this->content = View::factory('pages/trades/wants')
			->set('counters', $counters)
			->set('wants', $wants)
			->set('userCard', $userCard)
			->render();
	}

	public function action_confirmSending() {
		$tradeId = $this->request->post('tradeId');
		$trade = new Model_Trades_UserTradeEntity($tradeId);
		$trade->set('status', 'sending')->save();
		\Observer::trigger(new Event('Trade:ConfirmSending', $trade->as_array()));
		$this->content = true;
	}

	public function action_startTrade() {
		$wantId = $this->request->post('wantId');
		try {

			$trade = Model_Trades_UserOutTrades::instance($this->currentUser->id)
				->startTrade($wantId);
			$trade->set('status', 'pending')->save();
			$this->content = true;
		} catch (TradeCreatedFailException $e) {
			$this->content = false;
		}
	}

	public function action_sending() {
		$this->pageName = 'Отправляются';
		$this->activeMenu = 'trades/sending';
		$sendingCards = Model_Trades_UserOutTrades::instance($this->currentUser->id)->load();
		$this->content = View::factory('pages/trades/sending')
			->set('sendingCards', $sendingCards)
			->render();
	}

	public function action_receiving() {
		$this->pageName = 'Ожидаются';
		$this->activeMenu = 'trades/receiving';
		$receivingCards = Model_Trades_UserInTrades::instance($this->currentUser->id)->load();
		$this->content = View::factory('pages/trades/receiving')
			->set('receivingCards', $receivingCards)
			->render();
	}

	public function action_completeTradeIn() {
		$tradeId = $this->request->post('tradeId');
		try {
			Model_Trades_UserInTrades::instance($this->currentUser->id)->completeTrade($tradeId);
			$this->content = true;
		} catch (TradeInNotFoundException $e) {
			throw new HTTP_Exception_403;
		}
	}

	public function action_history() {
		$this->pageName = 'История сделок';
		$this->activeMenu = 'trades/history';
		$receivingCards = Model_Trades_UserHistoryTrades::instance($this->currentUser->id)->load();
		$this->content = View::factory('pages/trades/history')
			->set('historyTrades', $receivingCards)
			->render();
	}

	public function action_partners() {
		$this->pageName = 'Партнеры';
		$this->activeMenu = 'trades/partners';
		$this->content = 'partners';
	}
}