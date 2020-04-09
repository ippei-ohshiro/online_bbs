<?php
//データベース接続
$link = mysqli_connect("localhost", "root", "root", "online_bbs");
if(!$link){
    die('データベースに接続できません:' . mysqli_error($link));
}

mysqli_select_db($link, 'online_bbs');

$errors = array();


    //名前が正しいかチェック
    $name = "";
    if(!isset($_POST['name']) || !strlen($_POST['name'])){
        $errors['name'] = '名前を正しく入力してください';
    } elseif(strlen($_POST['name']) > 40) {
        $errors['name'] = '名前は４０文字以内で入力してください';
    } else {
        $name = $_POST['name'];
    }

    //ひとことが正しく入力されているかチェック
    $comment = "";
    if(!isset($_POST['comment']) || !strlen($_POST['comment'])) {
        $errors['comment'] = 'ひとことを入力してください';
    } elseif(strlen($_POST['comment']) > 200) {
        $errors['comment'] = 'ひとことは200文字以内で入力して下さい';
    } else {
        $comment = $_POST['comment'];
    }

    //エラーがなければ保存
    if(empty($errors)) {
        //保存用のSQL分作成
        $sql = "INSERT INTO post (name, comment,  created_at) VALUES ('"
            . mysqli_real_escape_string($link, $name) . "', '"
            . mysqli_real_escape_string($link, $comment) . "', '"
            . date('Y-m-d H:i:s') . "')"; 
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
        <?php if(isset($errors)): ?>
        <ul class="error_list">
            <?php foreach($errors as $error): ?>
            <li>
                <?php print htmlspecialchars($error, ENT_QUOTES) ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        名前: <input type="text" name="name"><br>
        ひとこと: <input type="text" name="comment" size="60"><br>
        <input type="submit" name="submit" value="送信">
    </form>
    <?php 
    //投稿された内容を取得するSQLを作成し、結果を取得
    $sql = "SELECT * FROM post ORDER BY created_at DESC";
    $result = mysqli_query($link, $sql);
    ?>

    <?php if($result !== false && mysqli_num_rows($result)): ?>
    <ul>
      

        <?php while($post = mysqli_fetch_assoc($result)): ?>
        <li>
            <?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>:
            <?php print(htmlspecialchars($post['comment'], ENT_QUOTES)); ?>
            - <?php print(htmlspecialchars($post['created_at'], ENT_QUOTES)); ?>
        </li> 
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>
    <?php
    //取得結果開放して接続を閉じる 
    mysqli_free_result($result);
    mysqli_close($link);
    ?>

</body>
</html> 