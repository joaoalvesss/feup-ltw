<?php function draw_login($session) { ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticket Manager</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/login_register.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h1>Login Page</h1>
		<form method="post" action="/../actions/action_login.php">

			<label for="username">Username:</label>
			<input type="text" name="username" id="username" placeholder="Enter your username" autocomplete="off">

			<label for="password">Password:</label>
			<input type="password" name="password" id="password" placeholder="Enter your password" autocomplete="off">

			<section id="messages">
      			<?php foreach ($session->getMessages() as $messsage) { ?>
       			<article class="<?=$messsage['type']?>">
          			<?=$messsage['text']?>
        			</article>
      			<?php } ?>
    			</section>

			<button type="submit">Login</button>

		</form>
		<p>Don't have an account yet? <a href="register.php">Register</a></p>
	</div>
</body>
</html>
<?php } ?>

<?php function draw_register($session) {?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticket Manager</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/login_register.css">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">;
</head>
<body>
	<div class="container">
		<h1>Register</h1>
		<form action="/../actions/action_register.php" method="post">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" placeholder="Enter your name" required autocomplete="off">
			
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="off">
			
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" placeholder="Enter your username" required autocomplete="off">
			
			<label for="password1">Password:</label>
			<input type="password" id="password1" name="password1" placeholder="Enter your password" required autocomplete="off">

               <label for="password2">Confirm Password:</label>
			<input type="password" id="password2" name="password2" placeholder="Confirm password" required autocomplete="off">
			
			<section id="messages">
      			<?php foreach ($session->getMessages() as $messsage) { ?>
       			<article class="<?=$messsage['type']?>">
          			<?=$messsage['text']?>
        			</article>
      			<?php } ?>
    			</section>

			<button type="submit">Register</button>
		</form>
		<p>Already have an account? <a href="login.php">Login here</a></p>
	</div>
</body>
</html>
<?php } ?>