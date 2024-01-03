<?php
    declare(strict_types = 1);

    include_once(__DIR__.'/../utils/session.php');
    include_once(__DIR__.'/../templates/authentication.tpl.php');

	if (isset($_SESSION['username']))
		die(header('Location: home.php'));

    $session = new Session();
	draw_login($session);
?>