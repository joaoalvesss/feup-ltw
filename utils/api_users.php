<?php
     declare(strict_types=1);

     session_start();

     require_once(__DIR__ . '/../database/connection.db.php');
     require_once(__DIR__ . '/../database/user.class.php');

     $db = getDatabaseConnection();
     $name = $_GET['search'] ?? '';

     $users = User::searchUsers($db, $name, 8);

     if ($users === false) {
          exit;
     }

     echo json_encode($users);
?>
