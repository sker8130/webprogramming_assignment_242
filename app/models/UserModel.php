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
        $username = $params["username"];
        $password = $params["password"];
        $email = $params["email"];
        $phoneNumber = $params["phoneNumber"];
        $gender = $params["gender"];
        $role = "member";
        $dob = $params["dob"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("insert into users (Username, PasswordHash, Email, Phone, Gender, Role, DateofBirth) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $hashedPassword, $email, $phoneNumber, $gender, $role, $dob);

        return $stmt->execute();
    }

    public function login($params)
    {
        $usernameEmail = $params["usernameEmail"];
        $password = $params["password"];


        $stmt = $this->db->prepare("select * from users where Username = ? or Email = ? limit 1");
        $stmt->bind_param("ss", $usernameEmail, $usernameEmail);

        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $stmt->close();
            return password_verify($password, $user["PasswordHash"]);
        }
        $stmt->close();
        return false;
    }
}