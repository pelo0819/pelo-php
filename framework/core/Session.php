<?php

/**
 * $_SESSIONを活用しログイン状態、ワンタイムトークンの管理を行う
 * $_SESSIONにセットした値のキャッシュは/var/lib/php/sessionsにある
 * 環境によっては代わるかもしれないので、phpinfo()を実行してsession.savepathを確認すること
 */
class Session
{
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    public function __construct()
    {
        if(!self::$sessionStarted)
        {
            session_start();
            self::$sessionStarted = true;
        }
    }

    /**
     * $_SESSION[$name]を取得する
     * @param $name : 取得するパラメタのキー
     * @param $defaults : セットされていない時のデフォルト値 
     */
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

    /**
     * $_SESSION[$name]をセットする
     * @param $name: セットしたいパラメタのキー
     * @param $value: セットするパラメタ
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * $_SESSIONからパラメタを削除する
     * @param $name : 削除するパラメタのキー
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * $_SESSIONを全削除する
     */
    public function clear()
    {
        $_SESSION = array();
    }

    /**
     * $_SESSION[_authenticated]をセットする
     */
    public function setAuthenticated($bflag)
    {
        $this->set('_authenticated', (bool)$bflag);
        $this->regenerate();
    }

    /**
     * 新規セッションIDを発行する
     * セッションID固定攻撃、セッションハイジャックへの対処法
     */
    public function regenerate($destroy = true)
    {
        if(!self::$sessionIdRegenerated)
        {
            session_regenerate_id($destroy);
            self::$sessionIdRegenerated = true;
        }

    }

    /**
     * ログイン状態か確認する
     */
    public function isAuthenticated()
    {
        return $this->get('_authenticated', false);
    }
}