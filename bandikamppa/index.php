<?php
require_once('inc/common.php');
require('inc/header.php');

if (!authorized()) {
	include('inc/loginform.php');
} else {
	include('inc/reservations.php');
}

require('inc/footer.php');
