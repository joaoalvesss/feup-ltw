<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../templates/faq.tpl.php');
  $session = new Session();
  $db = getDatabaseConnection();
  $session = new Session();

  if (!isset($_SESSION['id'])) {
    $session->addMessage('error', 'You must log into your account to access that page');
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
  }

  $user_id = $session->getId();

  $qry = "SELECT * FROM users WHERE id=$user_id";
  $stmt = $db->prepare($qry);
  $stmt->execute();
  $user = $stmt->fetch();
  $is_agent = $user['is_agent'];

  drawHeader($db, $session);
  draw_faq($db, $is_agent);
  drawFooter();

?>