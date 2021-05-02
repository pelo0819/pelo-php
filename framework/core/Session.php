<?php

class Session
{
    protected static $sessionStarted = false;

    public function __construct()
    {
        if(!self::$sessionStarted)
        {
            session_start();
            self::$sessionStarted = true;
        }
    }

    public function get($name, $default = null)
    {
        if(isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
        else
        {
            return $default;
        }
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
}