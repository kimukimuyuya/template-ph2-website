<?php
include_once '../dbconnect.php';

// ファイル名のユニーク化＋拡張子の取得
$image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
// イメージをどこに格納するのか　この場合はイメージディレクトリの場所を指定
$image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
// イメージディレクトリに実際にファイルを保存
move_uploaded_file(
  $_FILES['image']['tmp_name'], 
  $image_path
);


try {
  $stmt = $dbh->prepare('INSERT INTO questions(content, image, supplement) VALUES(:content, :image, :supplement)');
  $stmt->execute([
    "content" => $_POST["content"],
    "image" => $image_name,
    "supplement" => $_POST["supplement"]
  ]);
} catch (PDOException $e) {
  die("エラーメッセージ:{$e->getMessage()}");
}

$lastInsertId = $dbh->lastInsertId();
try {
  $stmt = $dbh->prepare('INSERT INTO choices(question_id, name, valid) VALUES(:question_id, :name, :valid)');

  for ($i=0; $i < count($_POST['choices']) ; $i++) { 
    $stmt->execute([
      "question_id" => $lastInsertId,
      "name" => $_POST["choices"][$i],
      "valid" => (int)$_POST["correctChoice"] === $i + 1 ? 1 : 0,
    ]);
  }
} catch (PDOException $e) {
  die("エラーメッセージ:{$e->getMessage()}");
}


?>