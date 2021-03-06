<?php
require_once('inc/common.php');
require_authorized();

$reservations_left = reservations_left($pgconn);

$day = date('Y-m-d');
$from = 10;
$to = 11;

if (!empty($_POST)) {
	$day = coalesce($_POST, 'day', $day);
	$from = (int) coalesce($_POST, 'from', $from);
	$to = (int) coalesce($_POST, 'to', $to);

	if ($to <= $from)
		$errors[] = 'Loppuu aikaisemmin kuin alkaa.';

	if ($from < $config['available_from']) 
		$errors[] = 'Alkaa liian aikaisin';

	if ($to > $config['available_to'])
		$errors[] = 'Loppuu liian myöhään';

	if (!preg_match('#(\d{4})-(\d{2})-(\d{2})#', $day, $match)) {
		$errors[] = 'Päivämäärä väärässä muodossa';
	}

	$y = (int) $match[1];
	$m = (int) $match[2];
	$d = (int) $match[3];

	// var_dump($y, $m, $d);
	// var_dump($day, $from, $to);
	// var_dump(mktime(0, 0, 0, $m, $d, $y), mktime($from, 0, 0, $m, $d, $y), time());

	if (mktime($from, 0, 0, $m, $d, $y) < time()) {
		$errors[] = 'Ei voi varata menneisyydestä';
	}

	$res_left = reservations_left($pgconn, $day);
	if ($to - $from > $res_left)
		$errors[] = 'Liian vähän varaustunteja jäljellä.';

	// insert
	if (empty($errors)) {
		$res = pg_query_ex($pgconn, 'begin;');
		if (!$res) die; // TODO

		try {
			for ($i = $from; $i < $to; $i++) {
				$res = pg_query_ex($pgconn,
					'insert into bandikamppa_reservations (uid, day, hour) values ({uid}, {day}, {hour});',
					array(
						'uid' => $_SESSION['uid'],
						'day' => $day,
						'hour' => $i,
					));
				if (!$res) {
					throw new Exception('Varaus epäonnistui, tarkista ettei ajat ole jo varattu.');
				}
			}

			$res = pg_query_ex($pgconn, 'commit;');

			if (!$res) {
				throw new Exception('Varaus epäonnistui, tarkista ettei ajat ole jo varattu.');
			}
		} catch (Exception $e) {
			$errors[] = $e->getMessage();
			pg_query_ex($pgconn, 'rollback;');
		}
	}
}

require('inc/header.php');
?>
	<p>
		<h1>Varaa</h1>
		Varaustunteja käytössä tässä kuussa: <?=$reservations_left?>
	</p>

	<form action="reserve.php" method="post" class="ui form">
		<div class="field">
			<label>Päivämäärä</label>
			<input type="text" name="day" value="<?=$day?>" placeholder="YYYY-MM-DD">
		</div>

		<div class="field">
			<label>Alkaen</label>
			<input type="text" name="from" value="<?=$from?>" placeholder="HH">
		</div>

		<div class="field">
			<label>Loppuen</label>
			<input type="text" name="to" value="<?=$to?>" placeholder="HH">
		</div>

		<button class="ui primary button" type="submit">Tee varaus</button>
	</form>
<?php
include('inc/reservations.php');

require('inc/footer.php');
