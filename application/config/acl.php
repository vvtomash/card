<?php defined('SYSPATH') or die('No direct script access.');

return [
	'Controller_Index' => [
		'index' => ['public'],
	],

	'Controller_Home' => [
		'index' => ['login'],
	],

	'Controller_Profile' => [
		'index' => ['login'],
		'update' => ['login'],
		'user' => ['public', 'login'],
	],

	'Controller_Login' => [
		'index' => ['public'],
		'logout' => ['public'],
	],

	'Controller_Signup' => [
		'index' => ['public'],
	],

	'Controller_Cards' => [
		'haves' => ['login'],
		'nextHaves' => ['login'],
		'wants' => ['login'],
		'nextWants' => ['login'],
		'imports' => ['login'],
		'remove' => ['login'],
		'add' => ['login'],
		'removeWant' => ['login'],
		'addWant' => ['login'],
		'change' => ['login'],
		'changeWant' => ['login'],
	],

	'Controller_Inbox' => [
		'index' => ['login'],
		'removeMessage' => ['login'],
		'nextMessage' => ['login'],
		'readMessage' => ['login'],
	],

	'Controller_Search' => [
		'index' => ['public'],
		'cards' => ['public'],
	],

	'Controller_Trades' => [
		//'send' => ['login'],
		'card' => ['login'],
		'startTrade' => ['login'],
		'confirmSending' => ['login'],
		'sending' => ['login'],
		'receiving' => ['login'],
		'completeTradeIn' => ['login'],
		'history' => ['login'],
		'partners' => ['login'],
	],

	'Controller_Collection' => [
		'index' => ['login'],
	]
];