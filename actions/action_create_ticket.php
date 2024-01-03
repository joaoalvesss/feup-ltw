<?php
     declare(strict_types = 1);

     require_once(__DIR__ . '/../database/user.class.php');
     require_once(__DIR__ . '/../database/connection.db.php');
     require_once(__DIR__ . '/../utils/session.php');

     $session = new Session();
     $db = getDatabaseConnection();

     // validate the form data
     $title = $_POST['title'] ?? '';
     $description = $_POST['description'] ?? '';
     $priority = $_POST['priority'] ?? '';
     $status = 0;
     $client_id = $session->getId();

     $department_name = $_POST['department'] ?? '';
     $department_id = null;

     // get department id
     if (!empty($department_name)) {
          $stmt = $db->prepare('SELECT id FROM departments WHERE name = ?');
          $stmt->execute(array($department_name));
          $department_id = $stmt->fetchColumn();
     }

     // get the hashtags, if any were entered
     $hashtags = $_POST['hashtags'] ?? '';

     // create the new ticket
     createTicket($db, $title, $description, $status, $priority, $department_id, $client_id, $hashtags);
?>