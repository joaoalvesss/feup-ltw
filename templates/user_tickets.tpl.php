<?php function draw_tickets_list($db, $session) { ?>
     <link rel="stylesheet" href="../css/user_tickets.tpl.css">
     <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <script src="../javascript/filter-tickets.js" defer></script>

     <div id="container">
          <div id="tickets-container">
               <h3 class='title'>Your Tickets</h3>
               <ul id="ticket-list">
               <?php
                    $user_id = $session->getId();
                    $qry = "SELECT * FROM tickets WHERE client_id=$user_id";
                    $stmt = $db->prepare($qry);
                    $stmt->execute();
                    $tickets = $stmt->fetchAll();
                    
                    if(!$tickets) {
                         echo "<p class='box'>You have no open tickets</p>";
                    }

                    foreach ($tickets as $ticket):
                         $title = $ticket['title'];
                         $ticket_id = $ticket['id'];
                         $description = $ticket['description'];
                         $tags = $ticket['tags'];
                         $status = $ticket['status'];
                         $priority = $ticket['priority'];
                         $departmentId = $ticket['department_id'];
                         $agentId = $ticket['agent_id'];

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

                         echo '<li class="box">';
                         echo "<form action='ticket_view.php' method='post'>
                                   <input type='hidden' id='id' name='id' value=$ticket_id>
                                   <button type='submit' class='link'>$title</button>
                              </form>";
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
                         echo "<p><strong> Department: </strong> <span class='department'>$departmentName</span> </p>";
                         echo "<p><strong> Agent: </strong> <span class='agent'>$agentName</span> </p>";
                         echo '</li>';
                    endforeach; 
               ?>
               </ul>
          </div>
          <div id="side-nav">
               <h3 class='title'>Tickets Details and Search</h3>
               <div id="search-container" class="box">
                    <h3 >Search</h3>
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
                              <option value="">Priorities Level</option>
                              <?php for ($i = 0; $i <= 9; $i++) { ?>
                                   <option value="<?php echo $i ?>"><?php echo $i ?></option>
                              <?php } ?>
                         </select>
                              
                         <select name="status">
                              <option value="">Statuses</option>
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
               <?php
                    $client_id = $session->getId();

                    $qry = "SELECT status, COUNT(*) AS count FROM tickets WHERE client_id=$client_id GROUP BY status";
                    $stmt = $db->prepare($qry);
                    $stmt->execute();
                    $counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

                    $qry = "SELECT agent_id, COUNT(*) AS count FROM tickets WHERE client_id=$client_id AND agent_id IS NOT NULL GROUP BY agent_id";
                    $stmt = $db->prepare($qry);
                    $stmt->execute();
                    $agent_counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
                         
                    echo '<div id="details-container"  class="box">';
                    echo '<p><strong>Number of tickets in each state:</strong></p>';
                    echo '<ul>';
                    echo '<li>Waiting to be opened: ' . ($counts[0] ?? 0) . '</li>';
                    echo '<li>Being solved: ' . ($counts[1] ?? 0) . '</li>';
                    echo '<li>Solved: ' . ($counts[2] ?? 0) . '</li>';
                    echo '</ul>';     
                    echo '<p><strong>Number of tickets assigned to each agent:</strong></p>';
                    echo '<ul>';

                    if (empty($agent_counts)) {
                         echo "<li>No agents assigned to your tickets yet!</li>";
                    } 
                    
                    else {
                         foreach ($agent_counts as $agent_id => $count) {
                              $qry = "SELECT name FROM users WHERE id=$agent_id";
                              $stmt = $db->prepare($qry);
                              $stmt->execute();
                              $agent_name = $stmt->fetchColumn();
                              
                              echo "<li>$agent_name: $count</li>";
                         }
                    }
                    echo '</ul>'; 
                    echo'</div>';
               ?>
          </div>
     </div>
<?php } ?>

<?php function draw_tickets_details($db, $ticket_id, $session) { ?>
     <link rel="stylesheet" href="../css/ticket_view.css">
     <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

     <div id="container">
          <div id="tickets-container" class="box">
          <?php 
               $qry = "SELECT * FROM tickets WHERE id=$ticket_id";
               $stmt = $db->prepare($qry);
               $stmt->execute();
               $ticket = $stmt->fetch();

               $title = $ticket['title'];
               $description = $ticket['description'];
               $status = $ticket['status'];
               $priority = $ticket['priority'];
               $departmentId = $ticket['department_id'];
               $agentId = $ticket['agent_id'];
               $tags = $ticket['tags'];

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

               echo "<h2>$title</h2>";
               echo "<p><strong>Description: </strong>$description</p>";
               echo "<p><strong>Tags: </strong>$tags</p>";
               echo "<p><strong>Status: </strong> $statusName";
               echo '<strong> Priority: </strong>';
               if ($priority >= 7) {
                    echo "<span class='priority-box red'>$priority</span>";
               } else if ($priority >= 4) {
                    echo "<span class='priority-box yellow'>$priority</span>";
               } else {
                    echo "<span class='priority-box green'>$priority</span>";
               }
               echo '</p>';
               echo "<p><strong> Department: </strong> $departmentName</p>";
               echo "<p><strong> Agent: </strong> $agentName</p>";
          ?>
          </div>

          <?php
               $id = $session->getId();
               $stmt = $db->prepare("SELECT is_agent FROM users WHERE id = ?");
               $stmt->execute([$id]);
               $isAgent = $stmt->fetchColumn();

               if ($isAgent) {
                    echo '<div id="agent-container" class="box">';
                    echo '<h2>Ticket Update Options</h2>';
                    echo '<form action="/../actions/action_change_ticket.php" method="post">';
                    echo '<select name="department">';
                    echo '<option value="">Department</option>';

                    $stmt = $db->prepare('SELECT id, name FROM departments');
                    $stmt->execute();
                    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($departments as $department) {
                         $id = $department['id'];
                         $name = $department['name'];
                         echo "<option value=\"$id\">$name</option>";
                    }                    

                    echo '</select>';
                         
                    echo '<select name="agent">';
                    echo '<option value="">Assigned Agent</option>';

                    $stmt = $db->prepare("SELECT id, name FROM users WHERE is_agent = 1");
                    $stmt->execute();
                    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
                    foreach ($agents as $agent) {
                         $agentId = $agent['id'];
                         $agentName = $agent['name'];
                         echo "<option value=\"$agentId\">$agentName</option>";
                    }

                    echo'</select>';

                    echo '<select name="status">';
                    echo '<option value="">Status</option>';
                    echo '<option value="0">Not started</option>';
                    echo '<option value="1">Being solved</option>';
                    echo '<option value="2">Solved</option>';
                    echo '</select>';

                    echo "<input type='hidden' id='ticket_id' name='ticket_id' value=$ticket_id>";

                    echo '<button type="submit">Update</button>';

                    echo '</form>';
                    echo '</div>';
               }
          ?>

          <div id="update-container" class="box">
               <?php 
                    $qry = "SELECT * FROM ticket_changes WHERE ticket_id=$ticket_id";
                    $stmt = $db->prepare($qry);
                    $stmt->execute();
                    $updates = $stmt->fetchAll();

                    if(!$updates){
                         echo "<div class='update'><h2>Updates:</h2>";
                         echo "<p style='text-indent: 1em;'class=''>No updates to your ticket yet.</p></div>";
                    }else{
                         foreach($updates as $update){
                              $user_id = $update['user_id'];

                              $qry = "SELECT name FROM users WHERE id=$user_id";
                              $stmt = $db->prepare($qry);
                              $stmt->execute();
                              $use = $stmt->fetchColumn();

                              $status = $update['status'];
                              $comment = $update['comment'];
                              $timestamp = $update['timestamp'];

                              echo "<div class='update'><h3>$user</h3>";
                              

                              $cmpString = "Ticket updated:";

                              if (strpos($cmpString, $comment) !== false || strpos($comment, $cmpString) !== false) {
                                   echo "<p class='comment'>$comment</p>";
                              } 
                              else {
                                   echo "<p class='comment'><strong>Comment: </strong>$comment</p>";
                              }

                              echo "<p class='date'> $timestamp</strong></div>";
                              
                         }
                    }
               ?>
               <div id="new-update">
                    <form action="/../actions/action_update_ticket.php" method="post"> 
                         <label for="comment">Make a new comment:</label>
                         <input type="text" id="comment" name="comment" placeholder="Follow up on this ticket" required autocomplete="off">
                         <?php
                              echo "<input type='hidden' id='ticket_id' name='ticket_id' value=$ticket_id>"
                         ?>
                         <button type="submit">Send</button>
                    </form>
               </div>
          </div>
     </div>
<?php } ?>