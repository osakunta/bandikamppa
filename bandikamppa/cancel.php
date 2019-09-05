<?php
require_once('inc/common.php');
require_authorized();

$reservations_left = reservations_left($pgconn);

$day = date('Y-m-d');
$from = 10;
$to = 11;

$message = '';

if (!empty($_POST)) {
	$rid = coalesce($_POST, 'rid');

	if ($rid) {
		$templatesql = "delete from bandi_reservations where rid = {rid} and reserved > now() - interval '15 minutes';";
		if (admin()) {
			$templatesql = "delete from bandi_reservations where rid = {rid}";
		}

		$res = pg_query_ex($pgconn,
			$templatesql,
			array('rid' => (int) $rid));

		if ($res && pg_affected_rows($res) == 1) {
			$messages[] = 'Varaus peruutettu onnistuneesti';
		} else {
			$errors[] = 'Varauksen peruutus epäonnistui';
		}
	}
}

require('inc/header.php');
include('inc/reservations.php');
require('inc/footer.php');
