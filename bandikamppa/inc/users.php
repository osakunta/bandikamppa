<?php
require_admin();

$res = pg_query_ex($pgconn, 'select uid, username, realname, email, hours, status from bandikamppa_users order by username;');

?>
<p>
	<h1>Käyttäjät</h1>
	<a href="user.php" class="ui primary button">Lisää uusi</a>
</p>

<table class="ui celled table">
<thead>
	<tr>
		<th>Käyttäjätunnus</th>
		<th>Nimi</th>
		<th>Sähköposti</th>
		<th>Tunteja</th>
		<th>Status</th>
		<th></th>
		<th></th>
	</tr>
</thead>

<?php while ($row = pg_fetch_assoc($res)): ?>
	<tr>
		<td><?=$row['username']?></td>
		<td><?=$row['realname']?></td>
		<td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
		<td><?=$row['hours']?></td>
		<td><?=$row['status'] == 'a' ? 'Admin' : 'Perus'?></td>
		<td><a href="user.php?uid=<?=$row['uid']?>" class="ui button">muokkaa</a></td>
		<td><a href="sudo.php?uid=<?=$row['uid']?>" class="ui button">sudo</a></td>
	</tr>
<?php endwhile; ?>
</table>
<?php
require('inc/footer.php');
