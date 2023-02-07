<?php
include_once '../dbconnect.php';

// file_get_contentsでinvitation.phpの値を持ってくる
// $raw = file_get_contents('php://input');
// JSON エンコードされた文字列を受け取り、それを PHP の値に変換
// $data = (array)json_decode($raw);

// やってることはedit.phpの最初のとこと全く一緒
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":email", $_POST["email"]);
$stmt->execute();
$user = $stmt->fetch();

// もしもうすでに$userが存在するならエラーメッセージ
if ($user) {
  $message = [
    "error" => [
      "message" => "招待済みのメールアドレスです"
    ]
  ];
  exit;
}

// update_questionと全く一緒、:emailのところは"email"で値を代入
$stmt = $dbh->prepare("INSERT INTO users(email) VALUES(:email)");
$stmt->execute([
  "email" => $_POST["email"]
]);


$user_id = $dbh->lastInsertId();
// ハッシュ化を行う。sha256というアルゴリズムを使う。uniqid(rand())でランダムな文字列を生成
$token = hash('sha256',uniqid(rand(),1));
$stmt = $dbh->prepare("INSERT INTO user_invitations(user_id, token) VALUES(:user_id, :token)");
$stmt->execute([
  "user_id" => $user_id,
  "token" => $token
]);

function send_invitation($email, $token)
{
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  define("MAIL_TO_ADDRESS", $email);
  define("MAIL_SUBJECT", "POSSEアプリに招待されています");
  define("MAIL_BODY", "こちらから登録してください。 http://localhost:8080/admin/auth/signup.php?token=$token&email=$email");
  define("MAIL_FROM_ADDRESS", "designare@example.jp");
  define("MAIL_HEADER", "Content-Type: text/plain; charset=UTF-8 \n".
                        "From: " . MAIL_FROM_ADDRESS . "\n".
                        "Sender: " . MAIL_FROM_ADDRESS ." \n".
                        "Return-Path: " . MAIL_FROM_ADDRESS . " \n".
                        "Reply-To: " . MAIL_FROM_ADDRESS . " \n".
                        "Content-Transfer-Encoding: BASE64\n");
  return mb_send_mail(MAIL_TO_ADDRESS , MAIL_SUBJECT , MAIL_BODY , MAIL_HEADER, "-f ".MAIL_FROM_ADDRESS);
}

send_invitation($_POST['email'], $token);




?>