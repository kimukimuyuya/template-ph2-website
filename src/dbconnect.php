<?php
/* ドライバ呼び出しを使用して MySQL データベースに接続する */
$dsn = 'mysql:dbname=posse;host=db';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);

// 検索クエスチョン
$sql_questions = 'SELECT * FROM questions';
$questions = $dbh->query($sql_questions)->fetchAll(PDO::FETCH_ASSOC);


// 検索チョイス

$sql_choices = 'SELECT * FROM choices';
$choices = $dbh->query($sql_choices)->fetchAll(PDO::FETCH_ASSOC);

// クエスチョンとチョイスを紐づける
foreach ($choices as $key => $choice) {
  $index = array_search($choice["question_id"], array_column($questions, 'id'));
  $questions[$index]["choices"][] = $choice;
}

// echo"<pre>";
// print_r($questions);
// echo"</pre>";

?>

