<?php
$config = array(
	'available_from' => 8,
	'available_to' => 22,
	'max_reservations' => 10,
	'db_connection' => 'host=' . $_ENV["DB_HOST"] . ' dbname=' . $_ENV["DB_NAME"] . ' user=' . $_ENV["DB_USER"] . ' password=' . $_ENV["DB_PASSWORD"]
);
