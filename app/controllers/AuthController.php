<?php
require_once "app/models/UserModel.php";
session_start();

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
            $this->userModel->register($admin);
        }
        $errors = [];
        $oldInput = [];
        if (isset($_POST["usernameEmail"])) {
            $oldInput = $_POST;
            $usernameEmail = $_POST["usernameEmail"];

            if ($this->userModel->checkUsernameExists($usernameEmail) == false && $this->userModel->checkEmailExists($usernameEmail) == false) {
                $errors["message"] = "** Username or email doesn't exists, please type again! **";
            }

            // if () {
            //     $errors["message"] = "** Email doesn't exists, please type again! **";
            // }

            if (empty($errors)) {
                if ($this->userModel->login($_POST)) {
                    $_SESSION['success_message'] = "Login successfully!";
                    $_SESSION["mySession"] = $usernameEmail;
                    setcookie("usernameEmail", $usernameEmail, time() + 3600);
                    $usernameEmail == "admin" ? header("Location: /webprogramming_assignment_242/admin") : header("Location: /webprogramming_assignment_242");
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
            setcookie("usernameEmail", "", time() - 3600);
        }

        header("location: /webprogramming_assignment_242/login");
    }
}