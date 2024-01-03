<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.db.php');

  class User {
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public int $is_agent;
    public int $is_admin;
    public int $department_id;
    public string $password;

    public function __construct(int $id, string $name, string $username, string $email, int $is_agent, int $is_admin, int $department_id){
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->is_agent = $is_agent;
        $this->is_admin = $is_admin;
        $this->department_id = $department_id;
    }

    public function verifyPassword(string $password) : bool {
      return password_verify($password, $this->password);
    }
    
    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {
      $stmt = $db->prepare('
        SELECT id, name, username, password, email, is_admin, is_agent, department_id
        FROM users
        WHERE lower(username) = ?
      ');
    
      $stmt->execute(array(strtolower($username)));
      $user = $stmt->fetch();
      
      if ($user && password_verify($password, $user['password'])) {
        return new User(
          (int) $user['id'],
          $user['name'],
          $user['username'],
          $user['email'],
          (int) $user['is_admin'],
          (int) $user['is_agent'],
          (int) $user['department_id']
        );
      } 
      else{
        return null;
      } 
    }
    
    static function searchUsers($db, $name, $limit): array {
      try {
        $stmt = $db->prepare('SELECT username, name, is_admin, is_agent, department_id FROM users WHERE username LIKE ? LIMIT ?');
        $stmt->execute(array('%' . $name . '%', $limit));
    
        $users = array();
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $users[] = array(
            'username' => $user['username'],
            'name' => $user['name'],
            'is_admin' => $user['is_admin'],
            'is_agent' => $user['is_agent'],
            'department_id' => $user['department_id']
          );
        }
        return $users;
      } catch (Exception $e) {

      }
    }
    
    
    static function getUser(PDO $db, int $id) : User {
      $stmt = $db->prepare('
        SELECT id, name, username, email, is_agent, is_admin
        FROM users
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $user = $stmt->fetch();
      
      return new User(
        $user['id'],
        $user['name'],
        $user['username'],
        $user['email'],
        $user['is_agent'],
        $user['is_admin'],
        $user['department_id']
      );
    }

    function save($db) {
      $stmt = $db->prepare('
        update users set name = ?, username = ?, password = ?, email = ?
        where id = ?
      ');
      $stmt->execute(array($this->name, $this->username, $this->password, $this->email, $this->id));
    }

  }

  function insertUser($db, $name, $username, $password, $email){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare('INSERT INTO users VALUES(NULL, ?, ?, ?, ?, ?, ?, NULL)');
    $stmt->execute(array($name, $username, $hashedPassword, $email, 0, 0));
  }
  
  function checkUserPassword($db, $username, $password) {
    $stmt = $db->prepare('SELECT password FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        $hashed_password = $row['password'];
        if(password_verify($password, $hashed_password)){
            return true;
        }
    }
    return false;
  }

  /////////////////////////////////////////// GETS ///////////////////////////////////////////

  function getHighestUserId(PDO $db) : int {
    $qry = 'SELECT MAX(id) FROM users';

    $stmt = $db->prepare($qry);
    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }
  
  ////////////////////////////////////////// UPDATES //////////////////////////////////////////

  function updateUserName($id, $name){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE users SET name = ? WHERE id = ?');
    $stmt->execute(array($name, $id));
  }

  function updateUserUsername($id, $username){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE users SET username = ? WHERE id = ?');
    $stmt->execute(array($username, $id));
  }

  function updateUserEmail($id, $email){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE users SET email = ? WHERE id = ?');
    $stmt->execute(array($email, $id));
  }

  function updateUserPassword($id, $password){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
    $stmt->execute(array($password, $id));
  }

  function updateUserIsAgent($id, $is_agent){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE users SET is_agent = ? WHERE id = ?');
    $stmt->execute(array($is_agent, $id));
  }

  function updateUserIsAdmin($id, $is_admin){
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE users SET is_admin = ? WHERE id = ?');
    $stmt->execute(array($is_admin, $id));
  }
  
  ////////////////////////////////////////// INSERTS //////////////////////////////////////////
  
  function createTicket($db, $title, $description, $status, $priority, $department_id, $client_id, $hashtags) {
    try {
        echo "Hastags: " . $hashtags;
        $stmt = $db->prepare('INSERT INTO tickets (id, title, description, status, priority, department_id, client_id, agent_id, tags) VALUES (NULL, ?, ?, ?, ?, ?, ?, NULL, ?)');
        $stmt->execute(array($title, $description, $status, $priority, $department_id, $client_id, $hashtags));

        header("Location: /../pages/home.php");
    } 
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  function createTicketChange($db, $ticket_id, $user_id, $status, $department_id, $hashtags, $comment, $faq_id) {
    try {
      $qry = "INSERT INTO ticket_changes (id, ticket_id, user_id, status, department_id, hashtags, comment, faq_id) VALUES (NULL, :ticket_id, :user_id, :status, :department_id, :hashtags, :comment, :faq_id)";
      $stmt = $db->prepare($qry);
      
      $stmt->bindParam(':ticket_id', $ticket_id);
      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':department_id', $department_id);
      $stmt->bindParam(':hashtags', $hashtags);
      $stmt->bindParam(':comment', $comment);
      $stmt->bindParam(':faq_id', $faq_id);

      $stmt->execute();



    $update_id = $db->lastInsertId();
    
    
    echo "<form action='/../pages/ticket_view.php' method='post' id='redirect'>
      <input type='hidden' id='id' name='id' value=$ticket_id>
      <input type='submit'>
    </form>";

    echo "<script>
      document.getElementById('redirect').submit();
    </script>";

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function createFaq($db, $question, $answer) {
  try{
    $qry = "INSERT INTO faqs (id, question, answer) VALUES (NULL, :question, :answer)";
    $stmt = $db->prepare($qry);
    
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':answer', $answer);

    $stmt->execute();

    $update_id = $db->lastInsertId();

    header("Location: /../pages/faq.php");
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function removeFaq($db, $faq_id) {
  try{
    $qry = "DELETE FROM faqs WHERE id = :id";
    $stmt = $db->prepare($qry);

    $stmt->bindParam(':id', $faq_id);

    $stmt->execute();

    header("Location: /../pages/faq.php");
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>
