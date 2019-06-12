<?php


namespace App\Controllers;
use App\View\View;
use App\Services\Db;

class MainController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function main()
    {
        $articles = $this->db->query('SELECT * FROM `articles`');

        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    public function sayHello($name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name]);

    }
}