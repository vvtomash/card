<?php defined('SYSPATH') or die('No direct script access.');

return [
	'Controller_Index' => [
		'index' => ['public'],
	],

	'Controller_Home' => [
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
	],

	'Controller_Search' => [
		'cards' => ['public'],
	]
];