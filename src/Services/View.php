<?php

namespace Bicycle\Services;

class View
{
    private $templatePath;

    public function __construct($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function html(string $templateName, array $vars = [])
    {
        extract($vars);

        //render partial content
        ob_start();
        include($this->templatePath . $templateName . '.php');
        $content = ob_get_clean();

        //render layout with $content
        ob_start();
        include($this->templatePath . 'layout.php');
        $layout = ob_get_clean();
        return $layout;
    }
}
