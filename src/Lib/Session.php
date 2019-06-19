<?php

namespace Bicycle\Lib;

class Session
{
    public $session_id;

    public function __construct()
    {
        session_start();
        $this->session_id = session_id();
    }
    
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function get($key)
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function clean()
    {
        session_unset();
    }

    public function commit()
    {
        session_commit();
    }
}
