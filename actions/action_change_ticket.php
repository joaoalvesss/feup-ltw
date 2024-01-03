<?php
     declare(strict_types = 1);

     require_once(__DIR__ . '/../database/user.class.php');
     require_once(__DIR__ . '/../database/connection.db.php');
     require_once(__DIR__ . '/../utils/session.php');

     $session = new Session();
     $db = getDatabaseConnection();

     $ticket_id = $_POST['ticket_id'] ?? '';
     $department = $_POST['department'] ?? '';
     $agent = $_POST['agent'] ?? '';
     $status = $_POST['status'] ?? '';

     $previousValuesStmt = $db->prepare('SELECT department_id, agent_id, status FROM tickets WHERE id = ?');
     $previousValuesStmt->execute([$ticket_id]);
     $previousValues = $previousValuesStmt->fetch(PDO::FETCH_ASSOC);

     if (!empty($department) && !empty($agent) && !empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET department_id = ?, agent_id = ?, status = ?
               WHERE id = ?
          ');
          $stmt->execute(array($department, $agent, $status, $ticket_id));
     } 
     
     elseif (empty($department) && !empty($agent) && !empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET agent_id = ?, status = ?
               WHERE id = ?
          ');
          $stmt->execute(array($agent, $status, $ticket_id));
     } 
     
     elseif (!empty($department) && empty($agent) && !empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET department_id = ?, status = ?
               WHERE id = ?
          ');
          $stmt->execute(array($department, $status, $ticket_id));
     } 
     
     elseif (!empty($department) && !empty($agent) && empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET department_id = ?, agent_id = ?
               WHERE id = ?
          ');
          $stmt->execute(array($department, $agent, $ticket_id));
     } 
     
     elseif (empty($department) && empty($agent) && !empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET status = ?
               WHERE id = ?
          ');
          $stmt->execute(array($status, $ticket_id));
     } 
     
     elseif (empty($department) && !empty($agent) && empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET agent_id = ?
               WHERE id = ?
          ');
          $stmt->execute(array($agent, $ticket_id));
     } 
     
     elseif (!empty($department) && empty($agent) && empty($status)) {
          $stmt = $db->prepare('
               UPDATE tickets SET department_id = ?
               WHERE id = ?
          ');
          $stmt->execute(array($department, $ticket_id));
     }

     if($status == 0){
          $statusName = "waiting to be opened";
     } elseif($status == 1){
          $statusName = "being solved";
     } elseif($status == 2){
          $statusName = "solved";
     }

     $departmentStmt = $db->prepare('SELECT name FROM departments WHERE id = ?');
     $departmentStmt->execute([$department]);
     $departmentName = $departmentStmt->fetchColumn();
     
     $agentStmt = $db->prepare('SELECT name FROM users WHERE id = ?');
     $agentStmt->execute([$agent]);
     $agentName = $agentStmt->fetchColumn();

     $comment = '<strong>Ticket updated:</strong>';
     if ($departmentName != $previousValues['department_name']) {
          $comment .= ' Department changed to <strong>'. $departmentName . '</strong>.';
     }
     if ($agentName != $previousValues['agent_name']) {
          $comment .= ' Agent changed to <strong>' . $agentName . '</strong>.';
     }
     if (($status != $previousValues['status']) && !empty($status)) {
          $comment .= ' Status changed to <strong>' . $statusName . '</strong>.';
     }
     

     $user_id = $session->getId();
     $hashtags = $_POST['hashtags'] ?? '';
     $faq_id = $_POST['faq_id'] ?? '';

     if($comment != "<strong>Ticket updated:</strong>"){
          $insertStmt = $db->prepare('
          INSERT INTO ticket_changes (ticket_id, user_id, status, department_id, hashtags, comment, faq_id)
          VALUES (?, ?, ?, ?, ?, ?, ?)
          ');
          $insertStmt->execute([$ticket_id, $user_id, $status, $department, $hashtags, $comment, $faq_id]);
     }

     echo "<form action='/../pages/ticket_view.php' method='post' id='redirect'>
          <input type='hidden' id='id' name='id' value=$ticket_id>
          <input type='submit'>
          </form>";

    echo "<script>
          document.getElementById('redirect').submit();
          </script>";
?>
