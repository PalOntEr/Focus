<?php


require_once __DIR__.'/../../config/db.php';

class UserModel {
    private $db;
    
    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getAllUsers() {
        $users = $this->db->queryFetchAll("CALL sp_Users (5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", []);
        foreach ($users as &$user) {
            if (isset($user['profilePicture'])) {
                $user['profilePicture'] = base64_encode($user['profilePicture']);
            }
        }
        return $users;
    }

    public function getUserByEmail($email) {
        $user = $this->db->queryFetch("CALL sp_Users (5, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", [
            $email
        ]);
        return $user;
    }

    public function loginUserByEmail($email) {
        $user = $this->db->queryFetch("CALL sp_Users (4, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", [
            $email
        ]);
        return $user;
    }

    public function getUserByEmailAndPassword($email, $password) {
        $user = $this->db->queryFetch("CALL sp_Users (4, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", [
            $email
        ]);

        if ($user && password_verify($password, $user['password'])) {
            if (isset($user['profilePicture'])) {
                $user['profilePicture'] = base64_encode($user['profilePicture']);
            }
            return $user;
        }

        return null;
    }

    public function createUser($username, $fullName, $email, $password, $role, $birthdate, $profilePicture, $gender) {
        return $this->db->queryInsert("CALL sp_Users (1, NULL, 'A', ?, ?, ?, ?, NULL, NULL, ?, ?, ?, ?)", [
            $username,
            $fullName,
            $email,
            $password,
            $role,
            $birthdate,
            $profilePicture,
            $gender
        ]);
    }

    public function updateUser($userId, $username, $fullName, $email, $password, $role, $birthdate, $profilePicture, $gender) {
        return $this->db->queryFetch("CALL sp_Users (2, ?, 'A', ?, ?, ?, ?, NULL, NULL, ?, ?, ?, ?)", [
            $userId,
            $username,
            $fullName,
            $email,
            $password,
            $role,
            $birthdate,
            $profilePicture,
            $gender
        ]);
    }
}
?>