<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../templates/admin_management.tpl.php');

    $session = new Session();
    $db = getDatabaseConnection();
    
    $user_id = $session->getId();
    $rank = $_POST['rank'];
    $department = $_POST['departmentId'];
    $target_id = $_POST['username'];

    if (empty($target_id) || empty($rank)) {
        $session->addMessage('error', 'Something went wrong.');
        header("Location: ../pages/admin_management.php");
        exit();
    }

    $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result && $result['is_admin'] == 1) {
        
        if ($rank == 'admin') {
            $stmt = $db->prepare('UPDATE users SET is_admin = ?, is_agent = ?, department_id = ? WHERE username = ?');
            $stmt->execute(array(1, 1, $department, $target_id));
        }
        else if ($rank == 'agent') {
            $stmt = $db->prepare('UPDATE users SET is_admin = ?, is_agent = ?, department_id = ? WHERE username = ?');
            $stmt->execute(array(0, 1, $department, $target_id));
        }
        else {
            $stmt = $db->prepare('UPDATE users SET is_admin = ?, is_agent = ?, department_id = ? WHERE username = ?');
            $stmt->execute(array(0, 0, NULL, $target_id));
        }

        $session->addMessage('success', 'Profile updated successfully!');
        header("Location: ../pages/admin_management.php");
        exit();
    } 
    else {    
        $session->addMessage('error', 'You must be an admin to perform this action.');
        header("Location: ../pages/home.php");
        exit();
    }
    
?>