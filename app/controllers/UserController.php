<?php
session_start();

require_once "app/models/UserModel.php";

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    public function adminIndex()
    {
        $oldInput = [];
        $tableHeader = "<th class='text-center'>ID</th>
        <th class='text-center'>Avatar</th>
        <th class='text-center'>Username</th>
        <th class='text-center'>Email</th>
        <th class='text-center'>Phone</th>
        <th class='text-center'>Role</th>
        <th class='text-center'>Login Status</th>
        <th class='text-center'></th>";
        $tableBody = "";
        $rows = $this->userModel->getAll();
        if (isset($_POST["searchForUsers"])) {
            $oldInput = $_POST;
            $userID = $_POST["userIDForUsers"];
            $username = $_POST["usernameForUsers"];
            $email = $_POST["emailForUsers"];
        }
        while ($row = $rows->fetch_assoc()) {
            $displayedEmail = htmlspecialchars($row["Email"]);
            $loginStatus = $row["loginAttempts"] == 5 ? "Locked" : "Normal";
            $candidate = "<tr>
        <td id='id'>{$row["UserID"]}</td>
        <td><img src='{$row["Avatar"]}' alt='idk' width='80'></td>
        <td>{$row["Username"]}</td>
        <td>{$displayedEmail}</td>
        <td>{$row["Phone"]}</td>
        <td>{$row["Role"]}</td>
        <td>{$loginStatus}</td>
        <td><a href='/webprogramming_assignment_242/admin/users/update?id={$row["UserID"]}'
                    class='btn btn-success'>Update</a>
            <a onclick='deleteConfirm({$row["UserID"]})' class='btn btn-danger'>Delete</a>
        </td>
    </tr>";
            if (isset($_POST["searchForUsers"])) {
                $cond1 = ($username == "") || ($username != "" && is_numeric(strpos(strtolower($row["Username"]), trim(strtolower($username)))));
                $cond2 = (!is_numeric($userID)) || (is_numeric($userID) && $userID == $row["UserID"]);
                $cond3 = ($email == "") || ($email != "" && is_numeric(strpos(strtolower($row["Email"]), trim(strtolower($email)))));
                if ($cond1 && $cond2 && $cond3) {
                    $tableBody .= $candidate;
                }
            } else {
                $tableBody .= $candidate;
            }
        }
        require_once "app/views/admin/users/users.php";
    }

    public function update()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $row = $this->userModel->getUserById($id);
        }

        if (isset($_POST["update"])) {
            $isLocked = isset($_POST["isLocked"]) ? false : true;
            if ($this->userModel->updateLoginStatus($isLocked, $id)) {
                $_SESSION['success_message'] = "Update successfully!";
                header("Location: /webprogramming_assignment_242/admin/users");
                exit();
            }
        }
        require_once "app/views/admin/users/update.php";
    }


    public function delete()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            if ($this->userModel->delete($id)) {
                header("Location: /webprogramming_assignment_242/admin/users");
                exit();
            }
        }
        require_once "app/views/admin/users/users.php";
    }
}