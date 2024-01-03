<?php function drawAdminManagement($db) { ?>
    <link rel="stylesheet" href="../css/admin_page.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="../javascript/filter-names.js" defer></script>

    <div id="container">
        <div id="users" class="box">
            <h2>Search user</h2>
            <label id="username" for="searchUsername">Search Username:</label>
            <input type="text" id="searchUsername" name="username" autocomplete="off">

            <ul id="searchResults"></ul>
        </div>

        <div id="userDetails" class="box" style="display: none;">
        
        <form id="userDetailsForm" style="display: none;" action="../actions/action_change_role.php" method="POST">
            <h2>User details</h2>
            <label for="usernameInput">Username:</label>
            <input type="text" id="usernameInput" name="username" readonly>
            <p></p>
            <label for="nameInput">Name:</label>
            <input type="text" id="nameInput" name="name" readonly>
            <p></p>
            <label for="rank">Rank:</label>
            <select id="rankInput" name="rank">
                <option value="user">User</option>
                <option value="agent">Agent</option>
                <option value="admin">Admin</option>
            </select>
            <p></p>
            <label for="departmentIdInput">Department:</label>
            <select id="departmentIdInput" name="departmentId">
                <?php
                $stmt = $db->prepare('SELECT id, name FROM departments');
                $stmt->execute();
                $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($departments as $department) {
                    echo '<option value="' . $department['id'] . '">' . $department['name'] . '</option>';
                }
                ?>
            </select>
            <p></p>
            <button type="submit">Save</button>
        </form>
        </div>

        <div id="departments" class="box">
            <h2>Add new department</h2>
            <form method="post" action="../actions/action_add_department.php" enctype="multipart/form-data">
                <label for="name">Department Name:</label>
                <input type="text" id="name" name="name" autocomplete="off" required>
            <p></p>
                <label for="description">Department Description:</label>
                <textarea id="description" name="description" required></textarea>
            <p></p>
                <label for="image">Upload Image:</label>
                <label for="image" class="custom-file-input">
                    Choose File
                    <input type="file" id="image" name="image" required>
                </label>
                <p></p>
                <button type="submit">Create Department</button>
            </form>
        </div>
    </div>
<?php } ?>
