<?php
    include_once('../utils/session.php');
    include_once('../templates/authentication.tpl.php');

    $session = new Session();

    if (isset($_SESSION['username']))
        die(header('Location: home.php'));

    draw_register($session);
?>
