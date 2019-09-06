<h2>SatO:n bändikämpän varauskone</h2>
<p>
	Jos haluat musiikkihuoneen käyttäjäksi, ota yhteyttä musiikkihuoneen hoitajaan:
	<a href="mailto:musiikkihuoneenhoitaja@satakuntatalo.fi">musiikkihuoneenhoitaja@satakuntatalo.fi</a>.
</p>

<h2>Kirjaudu sisään</h2>
<?php if ($username || $password) { ?>
	<p class="error">Väärä tunnus tai salasana</p>
<?php } ?>

<form action="login.php" method="POST">
	<table id="login-form-table">
		<tr><th>Käyttäjätunnus</th><td><input class="text" type="text" name="username" /></td></tr>
		<tr><th>Salasana</th><td><input class="text" type="password" name="password" /></td></tr>
		<tr><td class="centered" rowspan="2"><input type="submit" value="Sisään"></td></tr>
	</table>
</form>
