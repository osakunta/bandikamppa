<?php
 	header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<title>SatO</title>

	<meta name="Author" content="author" />
	<meta name="Description" content="Sato bandikamppa" />
	<meta name="Copyright" content="copyright" />
	<meta name="Keywords" content="Sato bandikamppa" />

	<link rel="stylesheet" href="static/screen.css" type="text/css" media="screen, projection" >
	<!-- <script src="static/less.js" type="text/javascript"></script> -->
</head>

<body>
	<div id="header"><div id="header-center"><a href="/"><img src="static/header_logo.png" /></a></div></div>

	<div id="content-outer">
		<div id="content">
<?php include('menu.php') ?>

<?php if (!empty($errors)): ?>
			<ul class="errors">
<?php foreach ($errors as $error): ?>
				<li><?=$error?></li>
<?php endforeach; ?>
			</ul>
<?php endif; ?>

<?php if (!empty($messages)): ?>
			<ul class="messages">
<?php foreach ($messages as $message): ?>
				<li><?=$message?></li>
<?php endforeach; ?>
			</ul>
<?php endif;
