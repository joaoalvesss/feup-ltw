<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $question = $_POST['new_question'] ?? '';
    $answer = $_POST['new_answer'] ?? '';
    
    createFaq($db, $question, $answer);
?>