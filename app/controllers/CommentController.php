<?php
require_once "app/models/CommentModel.php";

class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
    }


    public function adminIndex()
    {
        $oldInput = [];
        $tableHeader = "<th class='text-center'>ID</th>
        <th class='text-center'>ParentID</th>
        <th class='text-center'>BlogID</th>
        <th class='text-center'>Username</th>
        <th class='text-center'>Content</th>
        <th class='text-center'></th>";
        $tableBody = "";
        $rows = $this->commentModel->getAll();
        if (isset($_POST["searchForComments"])) {
            $oldInput = $_POST;
            $username = $_POST["usernameForComments"];
            $blogID = $_POST["blogIDForComments"];
            $content = $_POST["contentForComments"];
        }
        while ($row = $rows->fetch_assoc()) {
            $displayedContent = htmlspecialchars($row["Content"]);
            $candidate = "<tr>
                <td id='id'>{$row["CommentID"]}</td>
                <td style='width: 150px'>{$row["ParentID"]}</td>
                <td>{$row["BlogID"]}</td>
                <td>{$row["Username"]}</td>
                <td>{$displayedContent}</td>
                <td>
                    <a onclick='deleteConfirm({$row["CommentID"]})' class='btn btn-danger'>Delete</a>
                </td>
            </tr>";
            if (isset($_POST["searchForComments"])) {
                $cond1 = ($username == "") || ($username != "" && is_numeric(strpos(strtolower($row["Username"]), trim(strtolower($username)))));
                $cond2 = (!is_numeric($blogID)) || (is_numeric($blogID) && $blogID == $row["BlogID"]);
                $cond3 = ($content == "") || ($content != "" && is_numeric(strpos(strtolower($row["Content"]), trim(strtolower($content)))));
                if ($cond1 && $cond2 && $cond3) {
                    $tableBody .= $candidate;
                }
            } else {
                $tableBody .= $candidate;
            }
        }
        require_once "app/views/admin/comments/comments.php";
    }

    public function delete()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            if ($this->commentModel->delete($id)) {
                header("Location: /webprogramming_assignment_242/admin/comments");
                exit();
            }
        }
        require_once "app/views/admin/comments/comments.php";
    }
}