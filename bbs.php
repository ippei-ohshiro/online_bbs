<?php
//データベース接続
$link = mysqli_connect("127.0.0.1", "root", "root", "online_bbs", 8889);
if(!$link){
    die('データベースに接続できません:' . mysqli_error());
}

mysqli_select_db('online_bbs', $link);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ひとこと掲示板</title>
</head>
<body>
    <h1>ひとこと掲示板</h1>

    <form action="bbs.php" method="post">
        名前: <input type="text" name="name"><br>
        ひとこと: <input type="text" name="comment" size="60"><br>
        <input type="submit" name="submit" value="送信">
    </form>
</body>
</html>