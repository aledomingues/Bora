<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => '',
			'client_secret' => '',
			'scope'         => [],
		],
		'Linkedin' => [
		    'client_id'     => '',
		    'client_secret' => '',
			'scope'         => ['r_basicprofile', 'r_emailaddress', 'rw_company_admin'],
		],

	]

];