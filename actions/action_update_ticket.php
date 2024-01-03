<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $ticket_id = $_POST['ticket_id'] ?? '';
    $user_id = $session->getId();
    $status = 0;

    $qry = "SELECT department_id FROM tickets WHERE id = :id";
    $stmt = $db->prepare($qry);

    $stmt->bindParam(':id', $ticket_id);

    $stmt->execute();

    $department_id = $stmt->fetch();

    $hashtags = NULL;
    $comment = $_POST['comment'] ?? '';
    $faq_id = NULL;

    createTicketChange($db, $ticket_id, $user_id, $status, $department_id, $hashtags, $comment, $faq_id);
?>