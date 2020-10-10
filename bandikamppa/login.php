<?php
require_once('inc/common.php');

if (!empty($_POST)) {
	$username = coalesce($_POST, 'username');
	$password = coalesce($_POST, 'password');

	$res = pg_query_ex($pgconn,
		'select uid, status from bandikamppa_users where username = {username} and password = sha1(bytea(salt || {password}));',
		array('username' => $username, 'password' => $password));

	if ($res || pg_num_rows($res) > 0) {
		$row = pg_fetch_assoc($res);
		$_SESSION['uid'] = (int) $row['uid'];
		$_SESSION['status'] = $row['status'];
	}
}

require('inc/header.php');

if (!authorized()) {
	include('inc/loginform.php');

} else {
	include('inc/reservations.php');

}

require('inc/footer.php');
