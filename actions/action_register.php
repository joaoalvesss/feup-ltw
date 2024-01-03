<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();
    $session = new Session();

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password1 = $_POST['password1'] ?? '';
    $password2 = $_POST['password2'] ?? '';


    if (empty($name) || empty($email) || empty($username) || empty($password1) || empty($password2)) {
        die(header('Location: /../pages/register.php'));
    }

    if(preg_match('/\s/', $username)){
        $session->addMessage('error', 'Username cant have whitespaces!');
        die(header('Location: ../pages/register.php'));
    }

    if ($password1 !== $password2) {
        $session->addMessage('error', 'Passwords didnt match.');
        die(header('Location: /../pages/register.php'));
    }
    
    if (strlen($password1) < 8) {
        $session->addMessage('error', 'Password should have at least 8 characters.');
        die(header('Location: ../pages/register.php'));
    }
    
    if (!preg_match('/[A-Z]/', $password1)) {
        $session->addMessage('error', 'Password should have at least one uppercase character.');
        die(header('Location: ../pages/register.php'));
    }
    
    if (!preg_match('/\d/', $password1)) {
        $session->addMessage('error', 'Password should have at least one number.');
        die(header('Location: ../pages/register.php'));
    }

    $id = getHighestUserId($db);

    try {
        insertUser($db, $name, $username, $password1, $email);
        $session->setId($id + 1);
        $session->setName($name);
        $session->addMessage('success', 'Register successful!');
    } 

    catch (PDOException $e) {
        $session->addMessage('error', 'Something went wrong, try again!');
        die(header('Location: /../pages/register.php'));
    }

    header('Location: /../pages/login.php');
?>
