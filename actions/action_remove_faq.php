<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $db = getDatabaseConnection();

    $faq_id = $_POST['faq_id'] ?? '';
    
    
    removeFaq($db, $faq_id);
?>