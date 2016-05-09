<?php defined('SYSPATH') or die('No direct script access.');

return [
	'card' => [
		'conditions' => [
			'nm' => [
				'name' => 'Near Mint/Mint',
				'value' => 1
			],
			'sp' => [
				'name' => 'Slightly Played',
				'value' => 0.8
			],
			'mp' => [
				'name' => 'Moderately Played',
				'value' => 0.6
			],
			'hp' => [
				'name' => 'Heavily Played',
				'value' => 0.5
			],
			'dam' => [
				'name' => 'Damaged',
				'value' => 0.3
			],
		]
	]
];