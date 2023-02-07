<?php
include_once '../dbconnect.php';

$sql = "DELETE FROM choices WHERE question_id = :question_id";
$stmt = $dbh->prepare($sql);
$params = array(':question_id' => $_GET["id"]);
$stmt->execute($params);


// DELETE文を変数に格納
$sql = "DELETE FROM questions WHERE id = :id";
// 削除するレコードのIDは空のまま、SQL実行の準備をする
$stmt = $dbh->prepare($sql);
// 実際に削除するレコードのIDを配列に格納
$params = array(':id' => $_GET["id"]);
// 削除実行
$stmt->execute($params);








?>