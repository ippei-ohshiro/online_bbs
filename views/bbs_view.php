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