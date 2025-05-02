<?php
require_once "app/database/database.php";
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function getUserByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM tokens join users on UserID = UserID WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row;
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE UserID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row;
    }

    public function checkEmailExists($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($row = $result->fetch_assoc()) {
            return $row['UserID'];
        } else {
            return false;
        }
    }

    public function checkUsernameExists($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($row = $result->fetch_assoc()) {
            return $row['UserID'];
        } else {
            return false;
        }
    }

    public function register($params)
    {
        $username = $params["username"];
        $password = $params["password"];
        $email = $params["email"];
        $phoneNumber = $params["phoneNumber"];
        $avatar = "assets/default-pfp.avif";
        $gender = $params["gender"];
        $role = "member";
        $dob = $params["dob"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("insert into users (Username, PasswordHash, Email, Phone, Avatar, Gender, Role, DateofBirth) values (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $username, $hashedPassword, $email, $phoneNumber, $avatar, $gender, $role, $dob);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
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