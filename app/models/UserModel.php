<?php
require_once "app/database/database.php";
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from users");
        $stmt->execute();
        $rows = $stmt->get_result();
        $stmt->close();

        return $rows;
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
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("delete from users where UserID = ?");
        $stmt->bind_param("i", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function checkEmailExists($email)
    {
        $lowercaseEmail = strtolower($email);
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($row = $result->fetch_assoc()) {
            return $row;
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
            return $row;
        } else {
            return false;
        }
    }

    public function register($params)
    {
        $username = $params["username"];
        $password = $params["password"];
        $email = strtolower($params["email"]);
        $phoneNumber = $params["phoneNumber"];
        $avatar = "assets/default-pfp.png";
        $gender = $params["gender"];
        $role = isset($params["role"]) ? "admin" : "member";
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

    public function updateLoginAttempts($isSuccessfulLogin, $id)
    {
        $stmt = $isSuccessfulLogin ? $this->db->prepare("update users set loginAttempts = 0 where UserID = ?") : $this->db->prepare("update users set loginAttempts = loginAttempts + 1, lastAttemptTime = NOW() where UserID = ?");
        $stmt->bind_param("i", $id);
        $exists = $stmt->execute();
        return $exists;
    }

    public function updateLoginStatus($isLocked, $id)
    {
        $stmt = $isLocked ? $this->db->prepare("update users set loginAttempts = 0 where UserID = ?") : $this->db->prepare("update users set loginAttempts = 5, lastAttemptTime = NOW() where UserID = ?");
        $stmt->bind_param("i", $id);
        $exists = $stmt->execute();
        return $exists;
    }
}