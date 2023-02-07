<?php
include_once '../../dbconnect.php';
// include_once '../../services/delete_question.php';


// チョイスを定義している
$sql = "SELECT * FROM choices WHERE question_id = :question_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":question_id", $_REQUEST["id"]);
// $params = array(':question_id' => $_GET["id"]);
$stmt->execute();
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);



// クエスチョンを定義している
$sql = "SELECT * FROM questions WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
// $params = array(':id' => $_REQUEST["id"]);
$stmt->execute();
$question = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>問題更新画面</title>
  <link rel="stylesheet" href="../assets/styles/common.css">
  <link rel="stylesheet" href="../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <div class="wrapper">
    <div class="container">
      <h1 class="mb-4">問題編集</h1>
      <form action="../../services/update_question.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="question" class="form-label">問題文：</label>
          <input type="text" id="question" name="content" class="form-control required" value="<?= $question["content"] ?>" placeholder="問題文を入力してください">
        </div>
        <div class="mb-4">
          <label class="form-label">選択肢：</label>
          <?php foreach ($choices as $key => $choice) { ?>
            <input type="text" name="choices[]" class="required form-control mb-2" value="<?= $choice["name"]; ?>" placeholder="選択肢を入力してください">
          <?php } ?>

        </div>
        <div class="mb-4">
          <label for="form-label">正解の選択肢</label>
          <?php foreach ($choices as $key => $choice) { ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice<?= $key?>" <?= $choice["valid"] === 1 ? 'checked' : '' ?> value="<?= $key + 1 ?>">
              <label class="form-check-label" for="correctChoice<?= $key?>">
                選択肢<?= $key + 1 ?>
              </label>
            </div>
            
          <?php } ?>


        </div>
        <div class="mb-4">
          <label for="image" class="form-label">問題の画像</label>
          <input type="file" name="image" id="image" class="form-control required">
        </div>
        <div class="mb-4">
          <label for="supplement" class="form-label">補足</label>
          <input type="text" id="supplement" name="supplement" class="form-control"   value="<?= $question["supplement"] ?>" placeholder="補足を入力してください">
        </div>
        <!-- これをつけておくことで、create_question.phpでidを指定できる -->
        <input type="hidden" name="question_id" value="<?= $question["id"] ?>">
        <button type="submit">更新</button>
      </form>
    </div>
  </div>
</body>

</html>