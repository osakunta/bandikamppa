<?php if (authorized()): ?>
<div id="content-menu">
	<ul>
<?php if (admin()): ?>
		<li><a href="users.php">Käyttäjät</a></li>
<?php endif; ?>
		<li><a href="reservations.php">Varaukset</a></li>
		<li><a href="reserve.php">Varaa</a></li>

		<li><a href="logout.php">Ulos</a></li>
	</ul>
</div>
<? endif;
