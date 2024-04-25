<?php
require_once "./dbc.php";
$files = getAllFile();
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/styles.css">
    <title>アップロードフォーム</title>
  </head>
  <body>
    <form enctype="multipart/form-data" action="./file_upload.php" method="POST">
      <div class="file-up">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <!-- 画像の拡張子のみをacceptで選択 -->
        <input name="img" type="file" accept="image/*" /> 
      </div>
      <div>
        <textarea
          name="caption"
          placeholder="キャプション（140文字以下）"
          id="caption"
        ></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="送信" class="btn" />
      </div>
    </form>

    <h1>写真一覧</h1>
    <div class="photo-grid">
        <?php
        $files = getAllFile();
        foreach ($files as $file):
        ?>
        <a href="photo_detail.php?id=<?php echo $file['id']; ?>">
            <div class="photo-thumbnail">
                <img src="<?php echo $file['file_path']; ?>" alt="<?php echo $file['description']; ?>">
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</body>
</html>