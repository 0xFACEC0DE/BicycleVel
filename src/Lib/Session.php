<?php

namespace Bicycle\Lib;

class Session
{

    public function __construct($lifetime)
    {
        ini_set('session.gc_maxlifetime', $lifetime);
        ini_set('session.cookie_lifetime', $lifetime);
        session_start();
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
