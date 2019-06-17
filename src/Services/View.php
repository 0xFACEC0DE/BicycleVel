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
        if (!is_file($this->templatePath . $templateName . '.php')) {
            $templateName = 'errors/404';
        }
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

    public function json($value, $error = null)
    {
        $res = ['data' => $value ];
        if ($error) $res['error'] = $error;
        return json_encode($res);
    }
}
