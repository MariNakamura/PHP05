<?php
function dbc()
{
    $host ="mysql647.db.sakura.ne.jp";
    $dbname = "mari-nakamura_gs_kadai";
    $user = "mari-nakamura";
    $pass = "";

    $dns = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {
        $pdo = new PDO($dns, $user, $pass,
        [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}

/**
 * ファイルデータを保存
 * @param string $filename ファイル名
 * @param string $save_path 保存先のパス
 * @param string $caption 投稿の説明
 * @return bool $result
 */

function fileSave($filename, $save_path, $caption)
{
 $result = False;
 $sql = "INSERT INTO file_table(file_name, file_path, description) VALUE (?, ?, ?)";
 try {
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $filename);
    $stmt->bindValue(2, $save_path);
    $stmt->bindValue(3, $caption);
    $result = $stmt->execute();
    return $result;
  } catch(\Exception $e) {
    echo $e->getMessage();
    return $result;
  }
}

/**
 * ファイルデータを取得
 * @return array $fileData
 */
function getAllFile()
{
  $sql = "SELECT * FROM file_table";

  $fileData = dbc()->query($sql);

  return $fileData;
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); //セキュリティ
}


// 写真IDから写真データを取得する関数
function getFileById($id)
{
    $sql = "SELECT * FROM file_table WHERE id = ?";
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    return $stmt->fetch();
}

// 写真IDからコメントデータを取得する関数
function getCommentsByPhotoId($photo_id)
{
    $sql = "SELECT * FROM comments WHERE photo_id = ?";
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $photo_id);
    $stmt->execute();
    return $stmt->fetchAll();
}

// コメントを保存する関数
function saveComment($photo_id, $comment)
{
    $sql = "INSERT INTO comments (photo_id, comment) VALUES (?, ?)";
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $photo_id);
    $stmt->bindValue(2, $comment);
    return $stmt->execute();
}