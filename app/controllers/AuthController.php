<?php
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
session_start();

class AuthController
{
    private $userModel;
    private $tokenModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->tokenModel = new TokenModel();
    }


    public function register()
    {
        $errors = [];
        $oldInput = [];
        if (isset($_POST["username"])) {
            $oldInput = $_POST;
            $username = $_POST["username"];
            $email = $_POST["email"];

            if ($this->userModel->checkUsernameExists($username)) {
                $errors["message"] = "** Username already exists, please type again! **";
            }

            if ($this->userModel->checkEmailExists($email)) {
                $errors["message"] = "** Email already exists, please type again! **";
            }

            if (empty($errors)) {
                if ($this->userModel->register($_POST)) {
                    $_SESSION['success_message'] = "Registration successfully!";
                    header("Location: /webprogramming_assignment_242/login");
                    exit();
                } else {
                    $errors["message"] = "** Registration failed, please try again! **";
                }
            }
        }
        require_once "app/views/user/register/register.php";
    }

    public function login()
    {
        if ($this->userModel->checkUsernameExists("admin") == false) {
            $admin = [];
            $admin["username"] = "admin";
            $admin["password"] = "123";
            $admin["email"] = "admin@gmail.com";
            $admin["role"] = "admin";
            $this->userModel->register($admin);
        }
        $errors = [];
        $oldInput = [];
        $userID = 0;
        if (isset($_POST["usernameEmail"])) {
            $oldInput = $_POST;
            $usernameEmail = $_POST["usernameEmail"];
            $checkUsernameExists = $this->userModel->checkUsernameExists($usernameEmail);
            $checkEmailExists = $this->userModel->checkEmailExists($usernameEmail);

            if ($checkUsernameExists == false && $checkEmailExists == false) {
                $errors["message"] = "** Username or email doesn't exists, please type again! **";
            }

            if (empty($errors)) {
                if ($this->userModel->login($_POST)) {
                    $_SESSION["success_message"] = "Login successfully!";
                    $_SESSION["mySession"] = $usernameEmail;


                    if (isset($_POST["remember"])) {
                        $userID = $checkUsernameExists ? $checkUsernameExists : $checkEmailExists;
                        $token = bin2hex(random_bytes(32));
                        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));
                        setcookie("usernameEmail", $token, time() + (86400 * 7), "/");
                        $this->tokenModel->add($userID, $token, $expiresAt);
                    }

                    if ($usernameEmail == "admin" || $usernameEmail == "admin@gmail.com") {
                        header("Location: /webprogramming_assignment_242/admin");
                    } else {
                        header("Location: /webprogramming_assignment_242");
                    }
                    exit();
                } else {
                    $errors["message"] = "** Password is not correct, please type again! **";
                }
            }
        }
        require_once "app/views/user/login/login.php";
    }

    public function logout()
    {
        if (isset($_SESSION["mySession"])) {
            session_unset();
            session_destroy();

            $token = $_COOKIE["usernameEmail"];
            if (isset($token)) {
                setcookie("usernameEmail", "", time() - 3600, "/");
                $this->tokenModel->delete($token);
            }
        }

        header("location: /webprogramming_assignment_242/login");
    }
}