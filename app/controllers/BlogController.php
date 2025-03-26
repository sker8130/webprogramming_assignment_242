<?php

class BlogController
{
    public function index()
    {
        require_once "app/models/BlogModel.php";
        new BlogModel(); //initial connection
        // $result = BlogModel::list();
        require_once "app/views/user/blogs/blogs.php";
    }

    public function detail()
    {
        require_once "app/views/user/blogdetail/blogdetail.php";
    }
}
