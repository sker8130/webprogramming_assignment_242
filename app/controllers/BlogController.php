<?php
require_once "app/models/BlogModel.php";
session_start();



class BlogController
{
    private $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $htmlDisplayed = "";
        $rows = $this->blogModel->getAll();
        while ($row = $rows->fetch_assoc()) {
            if ($row["IsPublic"] == "yes") {
                $htmlDisplayed .= "<div class='card'>
                <img src='{$row["Image"]}' alt=''
                    style='width: 100%; border-top-left-radius: 20px; border-top-right-radius: 20px'>
                <h2 style='text-align: center; margin: 10px 20px'>{$row["Title"]}</h2>
                <p style='text-align:justify; margin: 0 15px'>{$row["Preview"]}...</p>
                <a href='/webprogramming_assignment_242/blogdetail?id={$row["BlogID"]}'><button class='view-more-button'>
                    Xem chi tiết
                </button></a>
            </div>";
            }
        }
        require_once "app/views/user/blogs/blogs.php";
    }

    public function detail()
    {
        require_once "app/views/user/blogdetail/blogdetail.php";
    }

    public function adminIndex()
    {
        $tableHeader = "<th class='text-center'>ID</th>
                                        <th class='text-center'>Created at</th>
                                        <th class='text-center'>Status</th>
                                        <th class='text-center'>Image</th>
                                        <th class='text-center'>Writer's name</th>
                                        <th class='text-center'>Title</th>
                                        <th class='text-center'></th>";
        $tableBody = "";
        $rows = $this->blogModel->getAll();
        while ($row = $rows->fetch_assoc()) {
            $status = $row["IsPublic"] == "yes" ? "Public" : "Private";
            $tableBody .= "<tr>
                                        <td id='id'>{$row["BlogID"]}</td>
                                        <td style='width: 150px'>{$row["CreatedAt"]}</td>
                                        <td>{$status}</td>
                                        <td><img src='{$row["Image"]}' alt='idk' width='100'></td>
                                        <td>{$row["WriterName"]}</td>
                                        <td>{$row["Title"]}</td>
                                        <td>
                                            <a href='/webprogramming_assignment_242/admin/blogs/update?id={$row["BlogID"]}'
                                                class='btn btn-success'>Update</a>
                                            <a onclick='deleteConfirm({$row['BlogID']})' class='btn btn-danger'>Delete</a>
                                        </td>
                                    </tr>";
        }

        require_once "app/views/admin/blogs/blogs.php";
    }

    public function add()
    {
        if (isset($_POST["add"])) {
            if ($this->blogModel->add($_FILES, $_POST)) {
                $_SESSION['success_message'] = "Add successfully!";
                header("Location: /webprogramming_assignment_242/admin/blogs");
                exit();
            }
        }
        require_once "app/views/admin/blogs/add.php";
    }

    public function update()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $row = $this->blogModel->getById($id)->fetch_assoc();
        }
        if (isset($_POST["update"])) {
            if ($this->blogModel->update($id, $_FILES, $_POST)) {
                $_SESSION['success_message'] = "Update successfully!";
                header("Location: /webprogramming_assignment_242/admin/blogs");
                exit();
            }
        }
        require_once "app/views/admin/blogs/update.php";
    }

    public function delete()
    {
        if ($_GET["id"]) {
            $id = $_GET["id"];
            if ($this->blogModel->delete($id)) {
                $_SESSION['success_message'] = "Delete successfully!";
                header("Location: /webprogramming_assignment_242/admin/blogs");
                exit();
            }
        }
        require_once "app/views/admin/blogs/blogs.php";
    }
}