<?php
require_once('inc/common.php');
require_admin();


$uid = (int) coalesce($_GET, 'uid');
if ($uid === 0) $uid = null;

if (!empty($_POST)) {
	$uid      = (int) coalesce($_POST, 'uid');
	if ($uid === 0) $uid = null;

	$username = coalesce($_POST, 'username', '');
	$realname = coalesce($_POST, 'realname', '');
	$email    = coalesce($_POST, 'email', '');
	$hours    = (int) coalesce($_POST, 'hours');

	if ($username === '') {
		$errors[] = 'tyhjä käyttäjätunnus';
		require('inc/header.php');
		require('inc/footer.php');
		exit;
	}

	if ($uid === null) {
		$res = pg_query_ex($pgconn, "select nextval('bandi_uid_seq');");
		$uid = (int) pg_fetch_result($res, 0, 0);

		pg_query_ex($pgconn, "insert into bandi_users (uid, username, realname, email, hours, status) values ({uid}, {username}, {realname}, {email}, {hours}, 'b');",
			array(
				'uid' => $uid,
				'username' => $username,
				'realname' => $realname,
				'email' => $email,
				'hours' => $hours
			));
	} else {
		pg_query_ex($pgconn, "update bandi_users set username = {username}, realname = {realname}, email = {email}, hours = {hours} where uid = {uid}",
			array(
				'uid' => $uid,
				'username' => $username,
				'realname' => $realname,
				'email' => $email,
				'hours' => $hours
			));
	}

	$pass1 = coalesce($_POST, 'pass1');
	$pass2 = coalesce($_POST, 'pass2');

	if ($pass1 !== null) {
		if ($pass1 === $pass2) {
			$salt = substr(uniqid("",true), 0, 16);
			pg_query_ex($pgconn, 'update bandi_users set salt = {salt}, password = sha1(bytea({salt} || {password})) where uid = {uid}',
				array(
					'uid' => $uid,
					'salt' => $salt,
					'password' => $pass1,
				));
		} else {
			$errors[] = 'salasanat eivät ole samat';
			require('inc/header.php');
			require('inc/footer.php');
			exit;
		}
	}

	header('Location: user.php?uid='.$uid);
	exit;
}

if ($uid !== null) {
	$res = pg_query_ex($pgconn, 'select uid, username, realname, email, hours, status from bandi_users where uid = {uid};', array('uid' => (int) $uid));
	$row = pg_fetch_assoc($res);
} else {
	$row = null;
}

if (!$row) {
	$row = array(
		'uid' => 0,
		'username' => '',
		'realname' => '',
		'email' => '',
		'hours' => 10,
		'status' => 'd'
	);
}

require('inc/header.php');

?>
<p>
	<?php if ($uid === null): ?>
		<h1>Uusi käyttäjä</h1>
	<?php else: ?>
		<h1>Käyttäjä</h1>
	<?php endif; ?>
</p>

<form action="user.php" method="post" class="ui form">
	<div class="field">
		<label>Käyttäjätunnus</label>
		<input type="text" name="username" value="<?=$row['username']?>" />
	</div>

	<div class="field">
		<label>Nimi</label>
		<input type="text" name="realname" value="<?=$row['realname']?>" />
	</div>

	<div class="field">
		<label>Sähköpostiosoite</label>
		<input type="text" name="email" value="<?=$row['email']?>" />
	</div>

	<div class="field">
		<label>Tunnit</label>
		<input type="text" name="hours" value="<?=$row['hours']?>" />
	</div>

	<div class="field">
		<label>Salasana</label>
		<input type="password" name="pass1" value="" />
	</div>

	<div class="field">
		<label>Salasana uudelleen</label>
		<input type="password" name="pass2" value="" />
	</div>

	<?php if ($uid !== null): ?>
		<input type="hidden" name="uid" value="<?=$uid ?>" />
	<?php endif; ?>

	<input class="ui primary button" type="submit" value="Tallenna">
	<input class="ui button" type="reset" value="Peruuta">
</form>

<?php require('inc/footer.php'); ?>
