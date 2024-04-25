<?php
require_once "./dbc.php";

//ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'images/';
$save_filename = date('YmdHis') . $filename;
$err_msgs = array();

// アップロードディレクトリが存在しない場合は作成する
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$save_path = $upload_dir . $save_filename;

//キャプションの取得
$caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);

//キャプションのバリデーション
//未入力
if (empty($caption)) {
    $err_msgs[] = 'キャプションを入力してください';
}
//140文字以内
if (strlen($caption) > 140) {
    $err_msgs[] = 'キャプションは140文字以内で入力してください';
}

//ファイルのバリデーション
//ファイルサイズが1MB未満
if ($filesize > 1048576 || $file_err == 2) {
    $err_msgs[] = 'ファイルサイズは1MB未満にしてください';
}
//拡張は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
if (!in_array(strtolower($file_ext), $allow_ext)) {
    $err_msgs[] = '画像ファイルを添付してください';
}

if (count($err_msgs) === 0) {
    //ファイルはあるか
    if (is_uploaded_file($tmp_path)) {
        if (move_uploaded_file($tmp_path, $save_path)) {
            $message = $filename . 'をアップロードしました';
            //DBに保存する
            $result = fileSave($filename, $save_path, $caption);
            if ($result) {
                $message .= '<div class="success-message">データベースに保存しました</div>';
            } else {
                $message = '<div class="error-message">データベースへの保存に失敗しました</div>';
            }
        } else {
            $message = '<div class="error-message">ファイルが保存できませんでした: ' . error_get_last()['message'] . '</div>';
        }
    } else {
        $message = '<div class="error-message">ファイルが選択されていません</div>';
    }
} else {
    $message = '<div class="error-message">';
    foreach ($err_msgs as $msg) {
        $message .= $msg . '<br>';
    }
    $message .= '</div>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>アップロード結果</title>
</head>
<body>
    <div class="message-container">
        <?php echo $message; ?>
    </div>
    <a href="./upload_form.php" class="back-link">戻る</a>
</body>
</html>