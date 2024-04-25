<?php
require_once "dbc.php";

if (isset($_POST['photo_id'])) {
    $photo_id = $_POST['photo_id'];

    // コメントデータを削除
    $sql = "DELETE FROM comments WHERE photo_id = ?";
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $photo_id);
    $stmt->execute();

    // 写真データを削除
    $sql = "DELETE FROM file_table WHERE id = ?";
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $photo_id);
    $stmt->execute();

    // 成功したら一覧ページにリダイレクト
    header("Location: upload_form.php");
    exit;
} else {
    echo "写真IDが指定されていません。";
}