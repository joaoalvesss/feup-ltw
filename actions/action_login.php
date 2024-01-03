<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $db = getDatabaseConnection();

  $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);
  
  $username = $_POST['username'];
  $password = ($_POST['password']);

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/login.php');
  }

  if (checkUserPassword($db, $username, $password)) {
    $session->setId($user->id);
    $session->setName($user->name);
    $session->addMessage('success', 'Login successful!');
    header('Location: /../pages/home.php');
  } 
  else {
    $session->addMessage('login_error', 'Invalid username or password!');
    die(header('Location: /../pages/login.php'));
  }
?>
