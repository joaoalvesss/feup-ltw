<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    

    if (empty($name) || empty($username) || empty($email)) {
        $session->addMessage('error', 'Please fill in all fields.');
        header("Location: ../pages/profile.php");
        exit();
    }

    $stmt = $db->prepare('SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?');
    $stmt->execute(array($username, $email, $user_id));
    $result = $stmt->fetch();
    if ($result) {
        $session->addMessage('error', 'Username or email already exists in the database.');
        header("Location: ../pages/profile.php");
        die();
    }
    
    if (!empty($password1) && !empty($password2) && $password1 == $password2) {
        $stmt = $db->prepare('UPDATE users SET name = ?, username = ?, email = ?, password = ? WHERE id = ?');
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $stmt->execute(array($name, $username, $email, $hashedPassword, $user_id));

    }
    else if (empty($password1) && empty($password2)) {
        $stmt = $db->prepare('UPDATE users SET name = ?, username = ?, email = ? WHERE id = ?');
        $stmt->execute(array($name, $username, $email, $user_id));
    }
    else {
        $session->addMessage('error', 'Please fill in all fields.');
        header("Location: ../pages/profile.php");
        exit();
    }
    
    $session->addMessage('success', 'Profile updated successfully!');
    header("Location: ../pages/home.php");
    exit();
?>