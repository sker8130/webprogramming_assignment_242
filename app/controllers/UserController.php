<?php

class UserController
{
    public function login()
    {
        // require_once "app/models/UserModel.php";

        require_once "app/views/user/login/login.php";
    }
    public function register()
    {
        // require_once "app/models/UserModel.php";

        require_once "app/views/user/register/register.php";
    }
}
