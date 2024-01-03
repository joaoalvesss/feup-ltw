<?php
     declare(strict_types = 1);

     require_once(__DIR__ . '/../templates/common.tpl.php');
     require_once(__DIR__ . '/../database/connection.db.php');
     require_once(__DIR__ . '/../templates/departments.tpl.php');
     require_once(__DIR__ . '/../utils/session.php');
     $db = getDatabaseConnection();
     $session = new Session();
     
     if (!isset($_SESSION['id'])) {
          $session->addMessage('error', 'You must log into your account to access that page');
          session_destroy();
          header("Location: ../pages/login.php");
          exit();
     }

     drawHeader($db, $session);
     draw_departments($db);
     drawFooter();
?>