<?php
$commonsql = "select r.rid, r.uid, r.day, u.username, r.hour, r.reserved > now() - interval '15 minutes' as cancelable from bandikamppa_reservations r inner join bandikamppa_users u using (uid) ";
if (admin() && coalesce($_GET, 'show_all') == 'yes') {
	$res = pg_query_ex($pgconn, $commonsql . "order by r.day;");
} else {
	$res = pg_query_ex($pgconn, $commonsql . "where r.day > current_date - interval '7 day' order by r.day;");
}

if (admin()) {
	function format_username($username, $uid) {
		printf('<a href="user.php?uid=%d">%s</a>', $uid, $username);
	}
} else {
	function format_username($username, $uid) {
		echo $username;
	}
}

if (admin()):
?>
<p>
	<h1>Varaukset</h1>
	<a href="reservations.php?show_all=yes" class="ui primary button">Näytä kaikki</a>
</p>
<?php
endif;

if ($res):
?>
<table id="reservations-table" class="ui celled table">
<thead>
	<tr>
		<th>Päivä</th>
		<th>Aika</th>
		<th>Varaaja</th>
		<th></th>
<?php if (admin()): ?>
		<th></th>
<?php endif; ?>
	</tr>
</thead>
<?php while ($row = pg_fetch_assoc($res)): ?>
	<tr>
		<td><?=$row['day']?></td>
		<td><?=$row['hour']?>&ndash;<?=$row['hour']+1?></td>
		<td><?php format_username($row['username'], (int) $row['uid']) ?></td>
		<td>
<?php if (($row['cancelable']=='t' && $_SESSION['uid'] == $row['uid']) || admin()): ?>
			<form action="cancel.php" method="post">
			<input type="hidden" name="rid" value="<?=$row['rid']?>" />
			<input type="submit" class="ui button" value="Peruuta" />
			</form>
<?php endif; ?>
		</td>
<?php if (admin()): ?>
		<td><?=$row['rid']?>
		<?=$row['uid']?>
		<?=($row['cancelable']=='t' && $_SESSION['uid'] == $row['uid']) || admin() ? 'true' : 'false' ?></td>
	</tr>
<?php endif; ?>
<?php endwhile; ?>
</table>
<?php endif; ?>
