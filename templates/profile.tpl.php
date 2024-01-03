<?php function draw_profile($db, $session) { 
    $user_id = $session->getId();
    $db = getDatabaseConnection();
    if (!isset($user_id)) {
        $session->addMessage('error', 'You must be logged in to update your profile.');
        header("Location: ../pages/login.php");
        exit();
    }
    
    try {
        $stmt = $db->prepare('SELECT name, username, email FROM users WHERE id = ?');
        $stmt->execute(array($user_id));
        $user = $stmt->fetch();

        $name = $user['name'];
        $username = $user['username'];
        $email = $user['email'];
?>

        <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/profile.css">

        <div id="container">
            <h2 class='title'>Edit Profile</h2>
            <form method="post" action="../actions/action_edit_profile.php" class='box'>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" autocomplete="off" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" autocomplete="off" required>

                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off" required>

                <label for="password1">New Password:</label>
			    <input type="password" id="password1" name="password1" placeholder="Enter your password" autocomplete="off">

                <label for="password2">Confirm Password:</label>
			    <input type="password" id="password2" name="password2" placeholder="Confirm password" autocomplete="off">

                <button type="submit">Save Changes</button>
            </form>
    </div>


<?php
    } catch(PDOException $e) {

    }
    return;
}
?>