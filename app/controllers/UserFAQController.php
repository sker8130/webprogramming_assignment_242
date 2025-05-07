<?php
require_once "app/models/FAQModel.php";
session_start();

class UserFAQController
{
    private $faqModel;

    public function __construct()
    {
        $this->faqModel = new FAQModel();
    }

    public function index()
    {
        $faq = $this->faqModel->getAll();

        require_once "app/views/user/faq/faq.php";
    }
}