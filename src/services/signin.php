<?php
include_once ('../dbconnect.php');


$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":email", $_POST["email"]);
$stmt->execute();
$user = $stmt->fetch();


// $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
if (password_verify($_POST['password'], $user['password'])) {
  //DBのユーザー情報をセッションに保存
  session_start();
  
  $_SESSION['id'] = $user['id'];
  $_SESSION['name'] = $user['name'];
  $msg = 'ログイン成功！';
  header('Location: /admin/index.php');
  exit;
  
}else{
  $msg = 'ログイン失敗しました';
}
echo $msg;
?>