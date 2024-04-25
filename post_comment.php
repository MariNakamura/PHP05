<?php
require_once "dbc.php";

$photo_id = $_POST['photo_id'];
$comment = $_POST['comment'];

if (saveComment($photo_id, $comment)) {
    header("Location: photo_detail.php?id=$photo_id");
    exit;
} else {
    echo "コメントの投稿に失敗しました。";
}