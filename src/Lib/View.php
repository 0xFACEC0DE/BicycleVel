<?php

namespace Bicycle\Lib;

class View
{
    private $templatePath;

    private $extraVars;

    public function __construct()
    {
        $this->templatePath =  __DIR__ . '/../../templates/';
        $this->extraVars = [];
    }

    public function setVar(string $name, $value)
    {
        $this->extraVars[$name] = $value;
    }

    public function html(string $templateName, array $vars = [])
    {
        if (!is_file($this->templatePath . $templateName . '.php')) {
            $templateName = 'errors/404';
        }
        extract($vars);

        ob_start();
        require($this->templatePath . $templateName . '.php');
        return ob_get_clean();
    }

    public function layoutHtml(string $templateName, array $vars = [])
    {
        $content = $this->html($templateName, $vars);

        $errors = isset($vars['errors']) ? $vars['errors'] : [];
        extract($this->extraVars);

        ob_start();
        require($this->templatePath . 'layout.php');
        return ob_get_clean();
    }

    public function json($value, $error = null)
    {
        $res = ['data' => $value ];
        if ($error) {
            $res['error'] = $error;
        }
        return json_encode($res);
    }
}