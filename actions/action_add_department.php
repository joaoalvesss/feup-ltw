<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../templates/admin_management.tpl.php');

    $session = new Session();
    $db = getDatabaseConnection();
    
    $user_id = $session->getId();
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result && $result['is_admin'] == 1) {
        $target_file = __DIR__.'/../docs/'. $_FILES["image"]['name'];

        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = '/../docs/'. $_FILES["image"]['name'];

            $stmt = $db->prepare('SELECT COUNT(*) AS total_departments FROM departments');
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_departments = $row['total_departments'];

            $stmt2 = $db->prepare("INSERT INTO departments (id, name, image_path, description) VALUES (?, ?, ?, ?)");
            $dpt_id = $total_departments + 1;
            $stmt2->execute([$dpt_id, $name, $image_path, $description]);

            $session->addMessage('sucess', 'Department added successfully!');
            header("Location: ../pages/admin_management.php");
            exit();
        } else {
            $session->addMessage('error', 'Something went wrong.');
            header("Location: ../pages/admin_management.php");
            exit();
        }
    } 
    else {    
        $session->addMessage('error', 'You must be an admin to perform this action.');
        header("Location: ../pages/home.php");
        exit();
    }
    
?>