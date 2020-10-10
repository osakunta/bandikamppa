<?
require_once('config.php');

// db
$pgconn = pg_connect($config['db_connection']);

function pg_query_ex($conn, $templatesql, $params = array()) {
	foreach ($params as $k => $v) {
		if (is_string($v)) {
			$v = "'".pg_escape_string($conn, $v)."'";
		}

		$templatesql = str_replace('{'.$k.'}', $v, $templatesql);
	}

	$res = pg_query($conn, $templatesql);
	// if (!$res) die('tietokantavirhe');
	return $res;
}

// session
session_start();

if (!isset($_SESSION['uid'])) {
	$_SESSION['uid'] = 0;
}

function authorized() {
	return $_SESSION['uid'] != 0;
}

function admin() {
	return $_SESSION['uid'] != 0 && $_SESSION['status'] == 'a';
}

function require_authorized() {
	if (authorized()) return;

	$errors[] = 'Unauthorized!';
	include('index.php');
	die;
}

function require_admin() {
	if (admin()) return;

	$errors[] = 'Unauthorized!';
	include('index.php');
	die;
}

if (authorized()) {
	$res = pg_query_ex($pgconn, 'select uid, username, realname, status, hours from bandikamppa_users where uid = {uid}', array('uid' => $_SESSION['uid']));
	$viewer = pg_fetch_assoc($res);
	$viewer['hours'] = (int) $viewer['hours'];
}

// generic

function coalesce($array, $val, $default = null) {
	return isset($array[$val]) ? $array[$val] : $default;
}

// reservations

function reservations_left($pgconn, $day = null ) {
	global $config;
	global $viewer;

	if ($day) {
		$res = pg_query_ex($pgconn,
			"select count(*) from bandikamppa_reservations where date_trunc('month', day) = date_trunc('month', date {day}) and uid = {uid};",
			array('day' => $day, 'uid' => $viewer['uid']));
	} else {
		$res = pg_query_ex($pgconn,
			"select count(*) from bandikamppa_reservations where date_trunc('month', day) = date_trunc('month', now()) and uid = {uid}",
			array('uid' => $viewer['uid']));
	}

	return $viewer['hours'] - pg_result($res, 0, 0);
}

// errors & messages
$errors = array();
$messages = array();
