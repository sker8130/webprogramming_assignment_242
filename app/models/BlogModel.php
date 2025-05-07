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
        // Kiểm tra xem file có tồn tại không
        if (!isset($fileParams['image']) || $fileParams['image']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $image = $fileParams['image'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];


        $maxFileSize = 2 * 1024 * 1024; // 2MB

        $imageTmpName = $image['tmp_name'];
        $imageOriginalName = basename($image['name']);
        $imageExtension = strtolower(pathinfo($imageOriginalName, PATHINFO_EXTENSION));
        $imageMimeType = mime_content_type($imageTmpName);
        $imageSize = $image['size'];

        // Kiểm tra phần mở rộng, loại MIME và kích thước
        if (
            !in_array($imageExtension, $allowedExtensions) ||
            !in_array($imageMimeType, $allowedMimeTypes) ||
            $imageSize > $maxFileSize ||
            !getimagesize($imageTmpName)
        ) {
            return false;
        }

        // Đảm bảo tên file không trùng và không độc hại
        $safeFileName = md5(uniqid() . $imageOriginalName) . '.' . $imageExtension;
        $uploadDir = 'app/views/admin/blogs/uploads/';
        $targetFile = $uploadDir . $safeFileName;

        // Đảm bảo thư mục tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!move_uploaded_file($imageTmpName, $targetFile)) {
            return false;
        }

        $title = $params["title"];
        $preview = $params["preview"];
        $content = $params["content"];
        $writerName = $params["writerName"];
        $isPublic = isset($params["isPublic"]) ? "yes" : "no";
        $stmt = $this->db->prepare("insert into blogs (Title, Preview, Content, Image, WriterName, IsPublic) values (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $preview, $content, $targetFile, $writerName, $isPublic);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function update($id, $fileParams, $params)
    {
        //cập nhật file ảnh vào folder uploads nếu có:
        $target_file = "";
        if (isset($fileParams["image"]) && isset($fileParams["image"]["tmp_name"]) && $fileParams["image"]["tmp_name"] !== "") {
            // Kiểm tra xem file có tồn tại không
            if (!isset($fileParams['image']) || $fileParams['image']['error'] !== UPLOAD_ERR_OK) {
                return false;
            }

            $image = $fileParams['image'];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];


            $maxFileSize = 2 * 1024 * 1024; // 2MB

            $imageTmpName = $image['tmp_name'];
            $imageOriginalName = basename($image['name']);
            $imageExtension = strtolower(pathinfo($imageOriginalName, PATHINFO_EXTENSION));
            $imageMimeType = mime_content_type($imageTmpName);
            $imageSize = $image['size'];

            // Kiểm tra phần mở rộng, loại MIME và kích thước
            if (
                !in_array($imageExtension, $allowedExtensions) ||
                !in_array($imageMimeType, $allowedMimeTypes) ||
                $imageSize > $maxFileSize ||
                !getimagesize($imageTmpName)
            ) {
                return false;
            }

            // Đảm bảo tên file không trùng và không độc hại
            $safeFileName = md5(uniqid() . $imageOriginalName) . '.' . $imageExtension;
            $uploadDir = 'app/views/admin/blogs/uploads/';
            $targetFile = $uploadDir . $safeFileName;

            // Đảm bảo thư mục tồn tại
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (!move_uploaded_file($imageTmpName, $targetFile)) {
                return false;
            }
        }


        $title = $params["title"];
        $preview = $params["preview"];
        $content = $params["content"];
        $writerName = $params["writerName"];
        $isPublic = isset($params["isPublic"]) ? "yes" : "no";
        if ($targetFile == "") {
            $stmt = $this->db->prepare("update blogs set Title = ?, Preview = ?, Content = ?, WriterName = ?, IsPublic = ? where BlogID = ?");
            $stmt->bind_param("sssssi", $title, $preview, $content, $writerName, $isPublic, $id);
        } else {
            $stmt = $this->db->prepare("update blogs set Title = ?, Preview = ?, Content = ?, Image = ?, WriterName = ?, IsPublic = ? where BlogID = ?");
            $stmt->bind_param("ssssssi", $title, $preview, $content, $targetFile, $writerName, $isPublic, $id);
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
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("delete from blogs where BlogID = ?");
        $stmt->bind_param("i", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }
}