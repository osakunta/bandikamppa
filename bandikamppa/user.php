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
<form action="user.php" method="post">
<table class="list">
	<tr>
		<th>Käyttäjätunnus</th>
		<td><input type="text" name="username" value="<?=$row['username']?>" /></td>
	</tr>
	<tr>
		<th>Nimi</th>
		<td><input type="text" name="realname" value="<?=$row['realname']?>" /></td>
	</tr>
	<tr>
		<th>Sähköpostiosoite</th>
		<td><input type="text" name="email" value="<?=$row['email']?>" /></td>
	</tr>
	<tr>
		<th>Tunnit</th>
		<td><input type="text" name="hours" value="<?=$row['hours']?>" /></td>
	</tr>
	<tr>
		<th>Salasana</th>
		<td><input type="password" name="pass1" value="" /></td>
	</tr>
	<tr>
		<th>Salasana 2</th>
		<td><input type="password" name="pass2" value="" /></td>
	</tr>
	<tr>
		<td colspan="2">
<?php if ($uid !== null): ?>
			<input type="hidden" name="uid" value="<?=$uid ?>" />
<?php endif; ?>
			<input type="submit" value="tallenna">
			<input type="reset" value="peruuta">
		</td>
	</tr>
</table>
</form>
<?php
require('inc/footer.php');

// <td><pre><?var_dump($row)?></pre></td>
