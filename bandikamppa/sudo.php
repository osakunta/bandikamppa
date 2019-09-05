<?php
require_once('inc/common.php');
require_admin();

$uid = (int) coalesce($_GET, 'uid');
if ($uid !== 0) {
	$_SESSION['uid'] = $uid;
	require('inc/header.php');
	include('inc/reservations.php');
	require('inc/footer.php');
} else {
	$errors[] = 'ALERT!';
	require('inc/header.php');
	include('inc/users.php');
	require('inc/footer.php');
}

