<?php
//データベース接続
$link = mysqli_connect("127.0.0.1", "root", "root", "online_bbs", 8889);
if(!$link){
    die('データベースに接続できません:' . mysqli_error());
}

mysqli_select_db($link, 'online_bbs');

$errors = array();

//POSTなら保存処理実行
if($_SERVER['REQUEST_METHOD'] === 'post'){
    //名前が正しいかチェック
    $name = null;
    if(!isset($_POST['name']) || !strlen($_POST['name'])){
        $errors['name'] = '名前を正しく入力してください';
    } elseif(strlen($_POST['name']) > 40) {
        $errors['name'] = '名前は４０文字以内で入力してください';
    } else {
        $name = $_POST['name'];
    }

    //ひとことが正しく入力されているかチェック
    $comment = null;
    if(!isset($_POST['comment']) || !strlen($_POST['comment'])) {
        $errors['comment'] = 'ひとことを入力してください';
    } elseif(strlen($_POST['comment']) > 200) {
        $errors['comment'] = 'ひとことは200文字以内で入力して下さい';
    } else {
        $comment = $_POST['comment'];
    }

    //エラーがなければ保存
    if(count($errors) === 0) {
        //保存用のSQL分作成
        $sql = "INSERT INTO post (name, comment,  created_at) VALUES ('"
            . mysqli_real_escape_string($name) . "', '"
            . mysqli_real_escape_string($comment) . "', '"
            . date('Y-m-d H:i:s') . "')"; 
    }

    //保存する
    mysqli_query($link, $sql);
}
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
        <!-- エラーメッセージ -->
        <?php if(count($errors)): ?>
        <ul class="error_list">
            <?php foreach($errors as $error): ?>
            <li>
                <?php echo htmlspecialchars($error, ENT_QUOTES) ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        
        名前: <input type="text" name="name"><br>
        ひとこと: <input type="text" name="comment" size="60"><br>
        <input type="submit" name="submit" value="送信">
    </form>
    
</body>
</html>