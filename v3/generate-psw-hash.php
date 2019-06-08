<?php
	$psw = htmlspecialchars(strip_tags($_GET['psw']));
	$psw_hash = password_hash($psw, PASSWORD_BCRYPT);
	echo $psw_hash;
?>