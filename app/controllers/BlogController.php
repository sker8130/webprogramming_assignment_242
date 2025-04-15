<?php
require_once "app/models/BlogModel.php";


class BlogController
{
    public function index()
    {
        // new BlogModel(); //initial connection
        // $result = BlogModel::list();
        require_once "app/views/user/blogs/blogs.php";
    }

    public function detail()
    {
        require_once "app/views/user/blogdetail/blogdetail.php";
    }
}