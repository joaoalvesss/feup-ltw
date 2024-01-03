<?php function draw_departments($db) { ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/departments.tpl.css">

    <div id= "container" class='departments-grid'>
          <?php
          try {
               $dqry = "SELECT * FROM departments";
               $dstmt = $db->prepare($dqry);
               $dstmt->execute();
               $departments = $dstmt->fetchAll();
               
               foreach ($departments as $department) {
                    $id = $department['id'];
                    $name = $department['name'];
                    $imagePath = $department['image_path'];
                    $description = $department['description'];

                    echo "<div class='department-container'>";
                    echo "<h2>$name</h2>";
                    echo "<img src='$imagePath' alt='$name' class='department-image'>";
                    echo "<p>$description</p>";
                    
                    $aqry = "SELECT * FROM users WHERE department_id = $id and is_agent = 1";
                    $astmt = $db->prepare($aqry);
                    $astmt->execute();
                    $agents = $astmt->fetchAll();
                    if (!empty($agents)) {
                         echo "<h3>Agents:</h3>";
                         echo "<ul>";
                         foreach ($agents as $agent) {
                              $agentName = $agent['name'];
                              echo "<li>$agentName</li>";
                         }
                         echo "</ul>";
                    }
                    else {
                         echo "<h3>Agents:</h3>";
                         echo "<ul>";
                         echo "<li>No agents in this department at the moment</li>";
                         echo "</ul>";
                    }
                    echo "</div>";
               }
          } 
        
          catch (PDOException $e) {
               echo "Error: " . $e->getMessage();
          }
          ?>
     </div>
<?php } ?>
