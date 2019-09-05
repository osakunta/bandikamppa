<?php
require_admin();

$res = pg_query_ex($pgconn, 'select uid, username, realname, email, hours, status from bandi_users order by username;');

?>
<p>
<a href="user.php">Lisää uusi</a>
</p>

<table class="list">
	<tr>
	<th>Käyttäjätunnus</th>
	<th>Nimi</th>
	<th>Sähköposti</th>
	<th>Tunteja</th>
	<th>Status</th>
	<th></th>
	</tr>
<?php while ($row = pg_fetch_assoc($res)): ?>
	<tr>
	<td><?=$row['username']?></td>
	<td><?=$row['realname']?></td>
	<td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
	<td><?=$row['hours']?></td>
	<td><?=$row['status'] == 'a' ? 'Admin' : 'Perus'?></td>
	<td><a href="user.php?uid=<?=$row['uid']?>">muokkaa</a></td>
	<td><a href="sudo.php?uid=<?=$row['uid']?>">sudo</a></td>
	</tr>
<?php endwhile; ?>
</table>
<?php
require('inc/footer.php');


