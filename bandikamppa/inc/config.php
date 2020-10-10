<?php
$config = array(
	'available_from' => 8,
	'available_to' => 22,
	'max_reservations' => 10,
	'db_connection' => 'host=' . getenv('DB_HOST') . ' dbname=' . getenv('DB_NAME') . ' user=' . getenv('DB_USER') . ' password=' . getenv('DB_PASSWORD')
);
