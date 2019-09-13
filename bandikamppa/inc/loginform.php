<p>
	<h1>Satakuntatalon bändikämpän varauskone</h1>
	Jos haluat musiikkihuoneen käyttäjäksi, ota yhteyttä musiikkihuoneen hoitajaan:
	<a href="mailto:musiikkihuoneenhoitaja@satakuntatalo.fi">musiikkihuoneenhoitaja@satakuntatalo.fi</a>.
</p>

<h2>Kirjaudu sisään</h2>
<?php if ($username || $password) { ?>
	<p class="error">Väärä tunnus tai salasana</p>
<?php } ?>

<form action="login.php" method="POST" class="ui form">
	<div class="field">
		<label>Käyttäjätunnus</label>
		<input type="text" name="username" placeholder="Käyttäjätunnus">
	</div>

	<div class="field">
		<label>Salasana</label>
		<input type="password" name="password" placeholder="Salasana">
	</div>

	<button class="ui primary button" type="submit">Kirjaudu</button>
</form>
