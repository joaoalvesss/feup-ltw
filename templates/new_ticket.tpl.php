<?php function draw_new_ticket($db) { ?>
     <link rel="stylesheet" href="../css/new_ticket.css">
     <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <script src="/../javascript/ticket_hashtags.js"></script>

     <div id="container">
          <h2>Create New Ticket</h2>
          <form method="post" action="/../actions/action_create_ticket.php" class='box'>
               <label for="title">Title:</label>
               <input type="text" id="title" name="title" placeholder="Enter your ticket tittle"required>

               <label for="description">Description:</label>
               <textarea id="description" name="description" placeholder="Enter your ticket description with the maximum detail possible" required></textarea>
               
               <label for="hashtags">Hashtags:</label>
               <input type="text" id="hashtags" name="hashtags" placeholder="Enter the ticket hashtags separated by spaces">

               <label for="priority">Priority:</label>
               <select id="priority" name="priority" required>
                    <?php for ($i = 0; $i <= 9; $i++) { ?>
                         <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
               </select>


               <label for="department">Department:</label>
               <select id="department" name="department">
                    <option value="">Select a department</option>
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

            <button type="submit">Submit Ticket</button>
         </form>
     </div>
<?php } ?>


