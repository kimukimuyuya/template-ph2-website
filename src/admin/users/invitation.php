<?php
include_once '../../dbconnect.php';


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ユーザー招待</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./../assets/styles/common.css">
  <link rel="stylesheet" href="./../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <main>
    <form action="" method="post">
      <div class="container">
        <h1 class="mb-4">ユーザー招待</h1>
        <!-- <form action="/admin/users/invitation.php" method="POST" id="form"> -->
        <input type="email" name="email" class="email">
        <input type="submit" id="button">
        <!-- </form> -->
      </div>
    </form>
  </main>
  <script>
    const btn = document.getElementById('button');
    const fd = new FormData();
    
    btn.addEventListener('click', ()=> {
      const input_email =document.querySelector('input[name=email]');
      fd.append('email', input_email.value);
      fetch('/services/create_user.php', {
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



      
    // asyncとawaitで非同期通信しているらしい
  </script>
</body>

</html>