<?php
require_once "app/core/database.php";

class ReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getLatestReviews($limit = 3)
    {
        $conn = $this->db->connect();
        $query = "SELECT r.*, u.Username, u.Avatar 
                  FROM reviews r 
                  JOIN users u ON r.UserID = u.UserID 
                  ORDER BY r.CreatedAt DESC 
                  LIMIT ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $reviews;
    }
}