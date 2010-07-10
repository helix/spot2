<?php
return array(
	'include_path' => array(
		dirname(__FILE__).'/../library/', # Spot library path
	),
	
	'adapter' => array(
		'mysql' => array(
			'host'	=> 'localhost',
			'user'	=> '', # Fill MySQL username here
			'pass'	=> '', # Fill MySQL password here
			'db'	=> 'test',
		),
		'mongodb' => array(
			'host'	=> 'localhost',
			'port'	=> '28017',
		),
	)
);