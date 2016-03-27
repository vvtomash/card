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
		'wants' => ['login'],
		'imports' => ['login'],
		'remove' => ['login'],
		'add' => ['login'],
		'removeWant' => ['login'],
		'addWant' => ['login'],
	],

	'Controller_Search' => [
		'index' => ['public'],
		'cards' => ['public'],
	],

	'Controller_Trades' => [
		'send' => ['login'],
		'startTrade' => ['login'],
		'sending' => ['login'],
		'receiving' => ['login'],
		'completeTradeIn' => ['login'],
		'history' => ['login'],
		'partners' => ['login'],
	]
];