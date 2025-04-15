<?php
require_once 'app/models/UserModel.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    public function register()
    {
        if (isset($_POST["username"])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phoneNumber'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];

            if ($this->userModel->checkUsernameExists($username)) {
                $errors['message'] = 'Username already exists';
            }

            if ($this->userModel->checkEmailExists($email)) {
                $errors['message'] = 'Email already exists';
            }

            if (empty($errors)) {
                if ($this->userModel->register($_POST)) {
                    header('Location: /webprogramming_assignment_242/login');
                    exit();
                } else {
                    $errors['general'] = 'Registration failed. Please try again.';
                }
            }
        }
        require_once "app/views/user/register/register.php";
    }

    public function login()
    {
        require_once "app/views/user/login/login.php";
    }
}