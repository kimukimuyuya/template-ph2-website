<?php
$token = isset($_GET['token']) ? $_GET['token'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;

// もしもクエリパラメータ（email = とかのやつ）がなかったら最初のページに飛ばす=>tokenがわからないと入れない=>セキュリティ対策になる
if (is_null($token) || is_null($email)) {
  # Errorページに送る
  header('Location: /');
}

// if(isset($_SESSION["id"])) {
//   header('Location: /admin/index.php');
// }



?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ユーザー登録</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./../assets/styles/common.css">
  <link rel="stylesheet" href="./../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <form action="" method="post">
    <main>
      <div class="container">
        <h1 class="mb-4">ユーザー登録</h1>
          <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" value="<?= $email ?>" class="email form-control" id="email" disabled>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control">
          </div>
          <input type="hidden" name="token" id="token" value="<?= $token ?>">
          <button type="submit" id="button">登録</button>
      </div>
    </main>
  </form>
  <script>
    const btn = document.getElementById('button');
    const fd = new FormData();
    
    btn.addEventListener('click', ()=> {
      const input_name =document.querySelector('input[name=name]');
      const input_email =document.querySelector('input[name=email]');
      const input_password =document.querySelector('input[name=password]');
      const input_token = document.querySelector('input[name=token]');
      fd.append('name', input_name.value);
      fd.append('email', input_email.value);
      fd.append('password', input_password.value);
      fd.append('token', input_token.value);

      fetch('/services/signup.php', {
        method:'POST',
        body: fd
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
      })
      .catch((error) => {
        console.log(error);
      });
    });
    
  </script>
</body>
</html>