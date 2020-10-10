<div id="content-menu" class="ui container">
	<ul>
		<li><a href="/">Bändikämppä</a></li>
	</ul>

	<?php if (authorized()): ?>
		<ul style="float:right;">
			<?php if (admin()): ?>
				<li><a href="users.php">Käyttäjät</a></li>
			<?php endif; ?>

			<li><a href="reservations.php">Varaukset</a></li>
			<li><a href="reserve.php">Varaa</a></li>
			<li><a href="logout.php">Ulos</a></li>
		</ul>
	<?php endif; ?>
</div>
