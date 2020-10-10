<?php
$config = array(
	'available_from' => 8,
	'available_to' => 22,
	'max_reservations' => 10,
	'db_connection' => 'host=' . env('DB_HOST') . ' dbname=' . env('DB_NAME') . ' user=' . env('DB_USER') . ' password=' . env('DB_PASSWORD')
);
