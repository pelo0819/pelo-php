<?php

$dsn = 'mysql: dbname=mini_blog; host=192.168.3.50';
$user = 'pelo';
$password = '0819Tobita';

$addr = $_SERVER["REMOTE_ADDR"];
echo 'addr='.$addr.'<br />'."\n";
$str = 'pelo';
try
{
    $con = new PDO($dsn, $user, $password);
    echo 'アクセス成功';
    $str = 'success';
}
catch(PDOException $e)
{
    echo 'アクセス失敗 ' .$e->getMessage();
    $str = 'falied'; 
    exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>bBs</title>
</head>
<body>
    <h1>one talk bBs</h1>
    <h2>
        abc <br>
        <?php
            echo $str;
        ?>
    </h2>
    <form action="bbs.php" method="post">
        name: <input type="text" name="name" /><br />
        one talk: <input type="text" name="comment" size="60" /><br />
        <input type="submit" name="submit" value="send" />
    </form>
</body>
</html>