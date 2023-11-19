<?php

class Login {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $username);
        $stmt->execute();
    
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUser() {
        if ($this->isLoggedIn()) {
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $_SESSION['user_id']);
            $stmt->execute();
            return $stmt->fetch();
        }
        return null;
    }


    public function generateCSRFToken() {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return  $token;
    }
    

    public function validateCSRFToken($token) {
        return $token === $_SESSION['csrf_token'];
    }

    public function createUser($email, $username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $username);
        $stmt->bindParam(3, $hashed_password);
        $stmt->execute();

        return $stmt->rowCount() == 1;
    }

}


?>