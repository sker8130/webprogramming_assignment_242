<?php
require_once "app/models/BlogModel.php";
require_once "app/models/CommentModel.php";
require_once "app/models/UserModel.php";
session_start();



class BlogController
{
    private $blogModel;
    private $commentModel;
    private $userModel;
    private $allBlogs;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->commentModel = new CommentModel();
        $this->userModel = new UserModel();
        $this->allBlogs = $this->blogModel->getAll();
    }

    public function index()
    {
        $htmlDisplayed = "";
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $startFrom = ($currentPage - 1) * 6;

        $publicBlogs = [];
        $searchQuery = $_GET['searchForBlogs'] ?? '';
        $oldInput = [];
        while ($row = $this->allBlogs->fetch_assoc()) {
            if ($row["IsPublic"] === "yes") {
                if ($searchQuery !== "") {
                    $oldInput["searchForBlogs"] = $searchQuery;
                    if (is_numeric(strpos(strtolower($row["Title"]), trim(strtolower($searchQuery))))) {
                        $publicBlogs[] = $row;
                    }
                } else {
                    $publicBlogs[] = $row;
                }
            }
        }

        $totalBlogs = count($publicBlogs);
        $totalPages = ceil($totalBlogs / 6);

        $blogsToDisplay = array_slice($publicBlogs, $startFrom, 6);
        foreach ($blogsToDisplay as $row) {

            $htmlDisplayed .= "<div class='card'>
            <img src='{$row["Image"]}' alt=''
                style='width: 100%; border-top-left-radius: 20px; border-top-right-radius: 20px'>
            <h2 style='text-align: center; margin: 10px 20px'>{$row["Title"]}</h2>
            <p style='text-align:justify; margin: 0 15px'>{$row["Preview"]}...</p>
            <a href='/webprogramming_assignment_242/blog?id={$row["BlogID"]}'><button class='view-more-button'>
                Xem chi tiết
            </button></a>
        </div>";
        }

        require_once "app/views/user/blogs/blogs.php";
    }

    public function detail()
    {
        $id = $_GET["id"];
        $row = $this->blogModel->getById($id)->fetch_assoc();
        $comments = $this->commentModel->getAllByBlogID($id);
        $otherBlogs = $this->blogModel->getAll();
        $usernameEmail = $_SESSION["mySession"];
        if (isset($usernameEmail)) {
            $checkUsernameExists = $this->userModel->checkUsernameExists($usernameEmail);
            $checkEmailExists = $this->userModel->checkEmailExists($usernameEmail);
            $userID = $checkUsernameExists ? $checkUsernameExists : $checkEmailExists;
        }
        if (isset($_POST["comment"])) {
            $parentID = isset($_POST["parentID"]) ? $_POST["parentID"] : null;

            if ($this->commentModel->add($parentID, $id, $userID, $_POST["comment"])) {
                $newCommentID = $this->commentModel->getLastComment()->fetch_assoc()["CommentID"];
                $_SESSION['scrollToComment'] = $newCommentID;

                if ($parentID !== null) {
                    $_SESSION['openResponds'] = $parentID;
                }

                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            }
        }

        if (isset($_GET["deletingCommentID"])) {
            $deletingCommentID = $_GET["deletingCommentID"];
            if ($this->commentModel->delete($deletingCommentID)) {
                if (isset($_GET["parentID"])) {
                    $_SESSION['scrollToComment'] = $_GET["parentID"];
                    $_SESSION['openResponds'] = $_GET["parentID"];
                }
                header("Location: /webprogramming_assignment_242/blog?id={$id}");
                exit();
            }
        }
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
            //isset??
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