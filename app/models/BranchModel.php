<?php 
require_once "app/database/database.php";
?>

<?php

class BranchModel
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
        $target_file = "app/views/admin/introduction/uploads/locations/$imagePath";
        move_uploaded_file($fileParams["image"]["tmp_name"], $target_file);

        $location = $params["location"];
        $description = $params["description"];
        $stmt = $this->db->prepare("insert into branches (location, description, image) values (?, ?, ?)");
        $stmt->bind_param("sss", $location, $description, $target_file);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function update($id, $fileParams, $params) 
    {
        $target_file = "";
        if (isset($fileParams["image"]) && isset($fileParams["image"]["tmp_name"]) && $fileParams["image"]["tmp_name"] !== "") {
            $imagePath = $fileParams["image"]["name"];
            $target_file = "app/views/admin/introduction/uploads/locations/$imagePath";
            move_uploaded_file($fileParams["image"]["tmp_name"], $target_file);
        }

        $location = $params["location"];
        $description = $params["description"];

        if ($target_file == "") {
            $stmt = $this->db->prepare("update branches set location = ?, description = ? where ID = ?");
            $stmt->bind_param("sss", $location, $description, $id);
        } else {
            $stmt = $this->db->prepare("update branches set location = ?, description = ?, image = ? where ID = ?");
            $stmt->bind_param("ssss", $location, $description, $target_file, $id);
        }
        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function delete($id) 
    {
        $stmt = $this->db->prepare("delete from branches where ID = ?");
        $stmt->bind_param("s", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function getAll() 
    {
        $stmt = $this->db->prepare("select * from branches");
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $rows;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("select * from branches where ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }
    
}