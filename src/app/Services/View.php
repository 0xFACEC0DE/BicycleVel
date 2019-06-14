<?php

namespace App\Services;

class View
{
    private $templatePath = __DIR__ . '/../../../templates/';

    public function renderHtml(string $templateName, array $vars = [], int $code = 200)
    {
        http_response_code($code);
        extract($vars);

        //render partial content
        ob_start();
        include($this->templatePath . $templateName . '.php');
        $content = ob_get_clean();

        //render layout with $content
        ob_start();
        include($this->templatePath . 'layout.php');
        $layout = ob_get_clean();
        echo $layout;
    }
}
