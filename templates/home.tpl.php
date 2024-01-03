<?php function draw_home($db) { ?>
     <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="../css/home.tpl.css">
     <script src="../javascript/filter-tickets.js" defer></script>

     <div id="container">
          <div id="tickets-container">
               <h2 class='title'>Tickets</h2>
               <ul id="ticket-list">
               <?php
                    $qry = "SELECT * FROM tickets";
                    $stmt = $db->prepare($qry);
                    $stmt->execute();
                    $tickets = $stmt;
                    
                    foreach ($tickets as $ticket):
                         $title = $ticket['title'];
                         $description = $ticket['description'];
                         $tags = $ticket['tags'];
                         $status = $ticket['status'];
                         $priority = $ticket['priority'];
                         $departmentId = $ticket['department_id'];
                         $clientId = $ticket['client_id'];
                         $agentId = $ticket['agent_id'];
                         $ticket_id = $ticket['id'];

                         $qry = "SELECT name FROM users WHERE id=$clientId";
                         $stmt = $db->prepare($qry);
                         $stmt->execute();
                         $clientName = $stmt->fetchColumn();
                         
                         $agentName = "No agent assigned yet";
                         if($agentId !== null){
                              $qry = "SELECT name FROM users WHERE id=$agentId";
                              $stmt = $db->prepare($qry);
                              $stmt->execute();
                              $agentName = $stmt->fetchColumn(); 
                         }

                         $departmentName = "Not department assigned";
                         if($departmentId){
                              $qry = "SELECT name FROM departments WHERE id=$departmentId";
                              $stmt = $db->prepare($qry);
                              $stmt->execute();
                              $departmentName = $stmt->fetchColumn();
                         }

                         if($status == 0){
                              $statusName = "Waiting to be opened!";
                         }
                         elseif($status == 1){
                              $statusName = "Being solved!";
                         }
                         elseif($status == 2){
                              $statusName = "Solved!";
                         }

                         echo "<li  class='box'>";
                         echo "<form action='ticket_view.php' method='post'>
                                   <input type='hidden' id='id' name='id' value=$ticket_id>
                                   <button type='submit' class='link'>$title</button>
                              </form>";;
                         echo "<p><strong>Description: </strong>$description</p>";
                         echo "<p><strong>Tags: </strong><span class='tags'>$tags</span></p>";
                         echo "<p><strong>Status: </strong> <span class='status'>$statusName</span>";
                         
                         echo '<strong> Priority: </strong>';
                         if ($priority >= 7) {
                           echo "<span class='priority-box red'>$priority</span>";
                         } else if ($priority >= 4) {
                           echo "<span class='priority-box yellow'>$priority</span>";
                         } else {
                           echo "<span class='priority-box green'>$priority</span>";
                         }
                         echo '</p>';
                         echo "<p><strong> Department: </strong> <span class='department'>$departmentName</span></p>";
                         echo "<p><strong>Client: </strong> $clientName";
                         echo "<strong> Agent: </strong> <span class='agent'>$agentName</span></p>";
                         echo '</li>';
                    endforeach; 
               ?>
               </ul>
          </div>
          <div id='side-nav'>
          <div id="search-container">
               <h2 class='title'>Search and Filter</h2>
               <div id='help' class='box'>
                    <h3>Search</h3>
                    <div id="search-bar">
                         <input type="text" placeholder="Search by title or hashtag">
                    </div>
                    
                    <h3>Filters</h3>
                    <div id="filters">
                         <select name="department">
                         <option value="">Departments</option>
                         <?php
                              $qry = 'SELECT name FROM departments';
                              $stmt = $db->prepare($qry);
                              $stmt->execute();
                              $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);

                              foreach ($departments as $department) {
                                   echo "<option value=\"$department\">$department</option>";
                              }
                         ?>
                         </select>
                              
                         <select name="agent">
                              <option value="">Agents</option>
                              <?php
                                   $qry = "SELECT id, name FROM users WHERE is_agent = 1";
                                   $stmt = $db->prepare($qry);
                                   $stmt->execute();
                                   $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                   
                                   foreach ($agents as $agent) {
                                        $agentId = $agent['id'];
                                        $agentName = $agent['name'];
                                        echo "<option value=\"$agentName\">$agentName</option>";
                                   }
                              ?>
                         </select>
                             
                         <select name="priority">
                              <option value="">Priority Level</option>
                              <?php for ($i = 0; $i <= 9; $i++) { ?>
                                   <option value="<?php echo $i ?>"><?php echo $i ?></option>
                              <?php } ?>
                         </select>
                              
                         <select name="status">
                              <option value="">Status</option>
                              <option value="Waiting to be opened!">Not started</option>
                              <option value="Being solved!">Being solved</option>
                              <option value="Solved!">Solved</option>
                         </select>
                         
                         <h3>Sorting</h3>
                         <select name="sort">
                              <option value="">Sort by</option>
                              <option value="priority_asc">Priority (Ascending)</option>
                              <option value="priority_desc">Priority (Descending)</option>
                         </select>

                         <button id="search-button" type="submit">Search</button>
               </div>
          </div>
          
          
          <div id='helper'>                         
          <div id="agents-container">
               <h2 class='title'>Agents</h2>
               <ul id="agent-list"  class='box'>
               <?php 
               $qry = "SELECT name, email FROM users WHERE is_agent = 1";
               $stmt = $db->prepare($qry);
               $stmt->execute();
               $agents = $stmt;
               foreach ($agents as $agent): ?>
                    <li><?= $agent['name'] ?> <p><?= $agent['email'] ?></p></li>
               <?php endforeach; ?>
               </ul>
          </div>
          
          <div id="departments-container">
               <h2 class='title'>Departments</h2>
               <ul id="department-list" class='box'>
               <?php 
               $qry = "SELECT * FROM departments";
               $stmt = $db->prepare($qry);
               $stmt->execute();
               $departments = $stmt;
               foreach ($departments as $department): ?>
                    <li><?= $department['name'] ?></li>
               <?php endforeach; ?>
               </ul>
          </div>
          </div>
     </div>
     </div>
<?php } ?>

