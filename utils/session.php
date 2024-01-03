<?php
  class Session {
     private array $messages;

     public function __construct() {
          session_start();

          $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
          unset($_SESSION['messages']);
     }

     public function isLoggedIn() : bool {
          return isset($_SESSION['id']);    
     }

     public function logout() {
          session_destroy();
     }

     public function getId() : ?int {
          return isset($_SESSION['id']) ? $_SESSION['id'] : null;
     }

     public function getName() : ?string {
          return isset($_SESSION['name']) ? $_SESSION['name'] : null;
     }

     public function setId(int $id) {
          $_SESSION['id'] = $id;
     }

     public function setName(string $name) {
          $_SESSION['name'] = $name;
     }

     public function addMessage(string $type, string $text) {
          $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
     }

     public function getMessages() {
          return $this->messages;
     }
     
     function printMessages() {
          $messages = $_SESSION['messages'];
          foreach ($messages as $message) {
            $type = $message['type'];
            $text = $message['text'];
            echo "<div class='alert alert-$type'>$text</div>";
          }
          // Clear the messages array after displaying them
          $_SESSION['messages'] = array();
        }
  }
?>