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
}