<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../templates/admin_management.tpl.php');

  $session = new Session();
  $db = getDatabaseConnection();
  $userId = $session->getId();
  
  $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = ?');
  $stmt->execute([$userId]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!isset($_SESSION['id']) || !($result && $result['is_admin'] == 1)) {
    $session->addMessage('error', 'You must log into your account to access that page');
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
  }

  drawHeader($db, $session);
  drawAdminManagement($db);
?>
