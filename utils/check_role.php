<?php
function getUserRank($userRoles) {
    if ($userRoles['is_admin'] == 1) {
        return 'admin';
    } elseif ($userRoles['is_agent'] == 1) {
        return 'agent';
    } else {
        return 'user';
    }
}

function checkUserRoles($db, $id) {
    try {
        $stmt = $db->prepare('SELECT is_admin, is_agent FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    } catch (PDOException $e) {
        return false;
    }
}

$id = $_GET['id'] ?? '';

if ($id !== '') {
    $userRoles = checkUserRoles($db, $id);

    if ($userRoles !== false) {
        $userRoles['rank'] = getUserRank($userRoles);
        echo json_encode($userRoles);
    }
}
?>
