<?php 
     declare(strict_types = 1); 
     require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader($db, Session $session) {

     $user_id = $session->getId();
     $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = ?');
     $stmt->execute([$user_id]);
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     if ($result && $result['is_admin'] == 1) {
          $isAdmin = true;
     }
     else {
          $isAdmin = false;
     }
?>
<!DOCTYPE html>
<html lang="en-US">
     <head>
          <title>Ticket Manager</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="../css/common.tpl.css">
          <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,400;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     </head>
     <body>
          <header>
               <h1>Ticket Manager</h1>
               <section id="messages">
      			<?php foreach ($session->getMessages() as $messsage) { ?>
       			<article class="<?=$messsage['type']?>">
          			<?=$messsage['text']?>
        			</article>
      			<?php } ?>
    			</section>
               
          </header>
          <div class="sidenav">
               <a href="home.php"><img src="../docs/home.png" alt="home" width="40" height="40"></a>
               <a href="ticket_list.php"><img src="../docs/ticket.png" alt="tickets" width="40" height="40"></a>
               <a href="new_ticket.php"><img src="../docs/add.png" alt="new_ticket" width="40" height="40"></a>
               <a href="profile.php"><img src="../docs/user.png" alt="profile" width="40" height="40"></a>
               <a href="departments.php"><img src="../docs/department.png" alt="departments" width="40" height="40"></a>
               <a href="faq.php"><img src="../docs/faq.png" alt="faq" width="40" height="40"></a>
               <?php if ($isAdmin) { echo '<a href="admin_management.php"><img src="../docs/management.png" alt="management" width="40" height="40"></a>'; } ?>
               <a href="../actions/action_logout.php"><img src="../docs/logout.png" alt="logout" width="40" height="40"></a>
          </div>
     <main>
<?php } ?>     
  


<?php function drawFooter() { ?>
     </main>
          <footer>
               <p>&copy; 2023 Ticket Manager. All rights reserved.</p>
          </footer>
     </body>
</html>
<?php } ?>


<?php function drawLogoutForm(Session $session) { ?>
     <form action="../actions/action_logout.php" method="post" class="logout">
          <a href="../pages/profile.php"><?=$session->getName()?></a>
          <button type="submit">Logout</button>
     </form>
<?php } ?>

<?php function colapseSidenav() { ?>
     <script>
          var checkBox = document.getElementById("colapse");
          var text = document.getElementsByClassName("sidenav");
  
          if (checkBox.checked == true){
               text.style.display = "flex";
          } else {
               text.style.display = "none";
          }
     </script>
<?php } ?>