<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 08.05.16
 * Time: 21:01
 */
class UserEventHandler {
	const CONFIRM_SENDING_TITLE = 'Отправка подверждена';

	public static function sendConfirmTradeMessage(Event $event) {
		$trade = $event->getData();
		$sender = new Model_User($trade['recipient_id']);
		$card = new Model_Cards_CardEntity($trade['card_id']);
		Model_Messages_Inbox::send(
			0,
			$trade['recipient_id'],
			self::CONFIRM_SENDING_TITLE,
			sprintf('Пользователь %s подвердил оправку карту "%s"', $sender->username ?: $sender->email, $card->name)
		);
	}

	public static function afterProfileUpdated(Event $event) {
		$profile = $event->getData();
		if (!$profile->checkFullness()) {
			Model_Cards_Wants::blockUserWants($profile->user_id);
		}
	}
}