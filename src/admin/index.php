<!-- _φ(･_･ 実装メモ
■index.phpの処理
データベースのquestions項目を検索
foreachを使って検索したデータをループ処理
idカラム、contentカラムの値を出力
　contentカラムの右に削除リンクを出力
　削除リンクはdelete_question.phpへのリンクとする

■delete_question.phpの処理
クエリパラメータで受け取ったidを対象にレコードを削除
削除後index.phpに遷移する

サンプルは上記と違う方法（Ajaxを利用した非同期通信）で実装しています
サンプルを読んで、非同期通信のAjaxを使った実装も理解しましょう -->

<?php
include_once '../dbconnect.php';

// echo "<pre>";
// print_r($questions);
// echo "<pre>";

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>問題一覧実装</title>
  <link rel="stylesheet" href="./assets/styles/common.css">
  <link rel="stylesheet" href="./admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../assets/scripts/common.js" defer></script>
</head>

<body>
  <main>
    <div class="container">
      <h1>問題一覧</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>問題</th>
            <th></th>
          </tr>
        </thead>
        
        <tbody>
          <?php foreach($questions as $key => $question) { ?>
          <tr id="question-<?= $question["id"]; ?>">
            <td><?= $question["id"]; ?></td>
            <td>
              <a href="./questions/edit.php?id=<?= $question["id"]; ?>">
                <?= $question["content"]; ?>
              </a>
            </td>
            <td>
              <a href="../services/delete_question.php?id=<?= $question["id"]; ?>">
                削除
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>