<?php require_once "dbc.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>写真詳細</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php $id = $_GET['id']; $file = getFileById($id); ?>
    <div class="photo-detail">
        <img src="<?php echo $file['file_path']; ?>" alt="<?php echo $file['description']; ?>">
        <p><?php echo $file['description']; ?></p>
        <form action="delete_photo.php" method="post">
            <input type="hidden" name="photo_id" value="<?php echo $id; ?>">
            <button type="submit">削除</button>
        </form>
    </div>
    <div class="comments">
        <h2>コメント</h2>
        <form action="post_comment.php" method="post">
            <input type="hidden" name="photo_id" value="<?php echo $id; ?>">
            <textarea name="comment" placeholder="コメントを入力..."></textarea>
            <button type="submit">送信</button>
        </form>
        <a href="upload_form.php">戻る</a>
        <?php $comments = getCommentsByPhotoId($id); foreach ($comments as $comment): ?>
            <div class="comment">
                <p><?php echo $comment['comment']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>