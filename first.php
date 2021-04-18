<?php

$link = mysql_connect('localhost', 'root', '');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>bBs</title>
</head>
<body>
    <h1>one talk bBs</h1>

    <form action="bbs.php" method="post">
        name: <input type="text" name="name" /><br />
        one talk: <input type="text" name="comment" size="60" /><br />
        <input type="submit" name="submit" value="send" />
    </form>
</body>
</html>