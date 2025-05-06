<?php

require_once "app/database/database.php";

?>

<?php

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function add($parentID, $blogID, $userID, $content)
    {
        $stmt = $this->db->prepare("insert into comments (ParentID, BlogID, UserID, Content) values (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $parentID, $blogID, $userID, $content);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from comments join users on comments.UserID = users.UserID");
        $stmt->execute();
        $rows = $stmt->get_result();
        $stmt->close();

        return $rows;
    }

    public function getAllByBlogID($blogID)
    {
        $stmt = $this->db->prepare("select * from comments join users on comments.UserID = users.UserID where BlogID = ? and ParentID is null order by comments.CreatedAt desc");
        $stmt->bind_param("s", $blogID);
        $stmt->execute();
        $rows = $stmt->get_result();
        $stmt->close();

        return $rows;
    }

    public function getAllByParentID($parentID)
    {
        $stmt = $this->db->prepare("select * from comments join users on comments.UserID = users.UserID where ParentID = ?");
        $stmt->bind_param("s", $parentID);
        $stmt->execute();
        $rows = $stmt->get_result();
        $stmt->close();

        return $rows;
    }

    public function getLastComment()
    {
        $stmt = $this->db->prepare("select * from comments order by comments.CreatedAt desc limit 1");
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }

    public function delete($commentID)
    {
        // $stmt = $this->db->prepare("delete from comments where ParentID = ?");
        // $stmt->bind_param("s", $commentID);
        // $stmt->execute();
        // $stmt->close();

        $stmt2 = $this->db->prepare("delete from comments where CommentID = ?");
        $stmt2->bind_param("s", $commentID);
        $exists = $stmt2->execute();
        $stmt2->close();

        return $exists;
    }
}