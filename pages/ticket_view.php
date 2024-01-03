<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../templates/user_tickets.tpl.php');

  $ticket_id = $_POST['id'];
  
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
  $is_admin = $user['is_admin'];
  
  $qry2 = "SELECT * FROM tickets WHERE id=$ticket_id";
  $stmt2 = $db->prepare($qry2);
  $stmt2->execute();
  $ticket = $stmt2->fetch();

  $creator = $ticket['client_id'];

  if($creator == $user_id){
    $is_creator = 1;
  }else{
    $is_creator = 0;
  }

  if($is_admin || $is_agent || $is_creator){
    drawHeader($db, $session);
    draw_tickets_details($db, $ticket_id, $session);
  }else{
    header("Location: /../pages/home.php");
  }
?>