<?php
	declare(strict_types = 1);
   
	require_once(__DIR__ . '/../templates/common.tpl.php');
	require_once(__DIR__ . '/../database/user.class.php');
	require_once(__DIR__ . '/../database/connection.db.php');
	require_once(__DIR__ . '/../utils/session.php');
	require_once(__DIR__ . '/../templates/new_ticket.tpl.php');
	
	$session = new Session();
	
	if (!isset($_SESSION['id'])) {
		$session->addMessage('error', 'You must log into your account to access that page');
		session_destroy();
		header("Location: ../pages/login.php");
		exit();
	}

	$db = getDatabaseConnection();
	drawHeader($db, $session);
	draw_new_ticket($db);
?>
