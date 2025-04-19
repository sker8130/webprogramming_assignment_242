<?php
require_once "app/models/BlogModel.php";


class BlogController
{
    public function index()
    {
        require_once "app/views/user/blogs/blogs.php";
    }

    public function detail()
    {
        require_once "app/views/user/blogdetail/blogdetail.php";
    }

    public function adminIndex()
    {
        require_once "app/views/admin/blogs/blogs.php";
    }
    public function add()
    {
        require_once "app/views/admin/blogs/add.php";
    }
}