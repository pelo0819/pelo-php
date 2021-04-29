<?php

// クラスをオートロードするクラス
// ClassLoaderクラスがあると、requireしていないクラスをインスタンス化した時、
// エラーを吐かないでインスタンス化してくれる
class ClassLoader
{
    // 検索対象ディレクトリ
    protected $dirs;

    // インスタンス生成された時に実行されるコールバックを登録
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    // 検索対象ディレクトリを登録
    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    // $classがインスタンス生成された場合に呼ばれるコールバック
    public function loadClass($class)
    {
        foreach($this->dirs as $dir)
        {
            $file = $dir . '/' . $class . '.php';
            if(is_readable($file))
            {
                require $file;
                return;
            }
        }
    }

}