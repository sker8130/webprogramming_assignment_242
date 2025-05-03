<?php

require_once "app/database/database.php";

?>

<?php

class BlogModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function add($fileParams, $params)
    {
        //upload file ảnh vào folder uploads:
        $imagePath = $fileParams["image"]["name"];
        $target_file = "app/views/admin/blogs/uploads/$imagePath";
        move_uploaded_file($fileParams["image"]["tmp_name"], $target_file);

        $title = $params["title"];
        $preview = $params["preview"];
        $content = $params["content"];
        $writerName = $params["writerName"];
        $isPublic = isset($params["isPublic"]) ? "yes" : "no";
        $stmt = $this->db->prepare("insert into blogs (Title, Preview, Content, Image, WriterName, IsPublic) values (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $preview, $content, $target_file, $writerName, $isPublic);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function update($id, $fileParams, $params)
    {
        //cập nhật file ảnh vào folder uploads nếu có:
        $target_file = "";
        if (isset($fileParams["image"]) && isset($fileParams["image"]["tmp_name"]) && $fileParams["image"]["tmp_name"] !== "") {
            $imagePath = $fileParams["image"]["name"];
            $target_file = "app/views/admin/blogs/uploads/$imagePath";
            move_uploaded_file($fileParams["image"]["tmp_name"], $target_file);
        }


        $title = $params["title"];
        $preview = $params["preview"];
        $content = $params["content"];
        $writerName = $params["writerName"];
        $isPublic = isset($params["isPublic"]) ? "yes" : "no";
        if ($target_file == "") {
            $stmt = $this->db->prepare("update blogs set Title = ?, Preview = ?, Content = ?, WriterName = ?, IsPublic = ? where BlogID = ?");
            $stmt->bind_param("ssssss", $title, $preview, $content, $writerName, $isPublic, $id);
        } else {
            $stmt = $this->db->prepare("update blogs set Title = ?, Preview = ?, Content = ?, Image = ?, WriterName = ?, IsPublic = ? where BlogID = ?");
            $stmt->bind_param("sssssss", $title, $preview, $content, $target_file, $writerName, $isPublic, $id);
        }
        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from blogs");
        $stmt->execute();
        $rows = $stmt->get_result();
        $stmt->close();

        return $rows;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("select * from blogs where BlogID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("delete from blogs where BlogID = ?");
        $stmt->bind_param("s", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }
}