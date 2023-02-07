<?php
require_once '../dbconnect.php';

// まず、paramsを用意する、updateを使うときにはwhere句で場所を指定しないといけないから、paramsのなかにidを用意
$params = [
  "content" => $_POST['content'],
  "supplement" => $_POST['supplement'],
  // edit.phpの81行目参照
  "id" => $_POST['question_id']
  ];
  
$set_query = "SET content = :content, supplement = :supplement";
// 一時保存ファイル名が空欄でなかったら＝ファイルがな入力されているのなら
if ($_FILES["image"]["tmp_name"] !== ""){
  // セットクエリに.=で追加する
  $set_query .= ", image = :image";
  $params["image"] = "";
}

$sql = "UPDATE questions $set_query WHERE id = :id";

// このif文がないとうまくいかない。写真がセットされているならっていう意味
if(isset($params["image"])) {
  // ファイル名のユニーク化＋拡張子の取得
  $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  // イメージをどこに格納するのか　この場合はイメージディレクトリの場所を指定
  $image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
  // イメージディレクトリに実際にファイルを保存
  move_uploaded_file(
  $_FILES['image']['tmp_name'], 
  $image_path
  );
  // イメージにimage_nameをセット
  $params["image"] = $image_name;
}


$stmt = $dbh -> prepare($sql);
$result = $stmt -> execute($params);

// なんでchoicesのほうはupdate使わないんだろう

$sql = "DELETE FROM choices WHERE question_id = :question_id";
$stmt = $dbh->prepare($sql);
$params = array(':question_id' => $_POST["question_id"]);
$stmt->execute($params);

$stmt = $dbh->prepare('INSERT INTO choices(question_id, name, valid) VALUES(:question_id, :name, :valid)');

  for ($i=0; $i < count($_POST['choices']) ; $i++) { 
    $stmt->execute([
      "question_id" => $_POST['question_id'],
      "name" => $_POST["choices"][$i],
      "valid" => (int)$_POST["correctChoice"] === $i + 1 ? 1 : 0,
    ]);
  }







?>