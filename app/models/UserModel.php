<?php
require_once "app/database/database.php";
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function checkEmailExists($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function checkUsernameExists($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function register($params)
    {
        $username = $params['username'];
        $password = $params['password'];
        $email = $params['email'];
        $phoneNumber = $params['phoneNumber'];
        $gender = $params['gender'];
        $role = $username == "admin" ? "admin" : "member";
        $dob = $params['dob'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("insert into users (Username, PasswordHash, Email, Phone, Gender, Role, DateofBirth) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $hashedPassword, $email, $phoneNumber, $gender, $role, $dob);

        return $stmt->execute();
    }
}