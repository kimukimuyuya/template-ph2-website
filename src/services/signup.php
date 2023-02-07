<?php
include_once '../dbconnect.php';

// もともとinvitationの段階でemailはinsertされてるから、emailが一致するところの行をとってくる
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":email", $_POST["email"]);
$stmt->execute();
$user = $stmt->fetch();

// 上と同様。insertするときのfrom句でつかうために定義している
// $sql = "SELECT * FROM user_invitations WHERE token = :token AND user_id = :user_id";
$sql = "SELECT * FROM user_invitations WHERE token = :token";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":token", $data["token"]);
// $stmt->bindValue(":user_id", $user["id"]);
$stmt->execute();
$user_invitation = $stmt->fetch();

// $sql = "UPDATE users SET name = :name, password = :password WHERE id = :id";
$sql = "UPDATE users SET name = :name, password = :password WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":password", password_hash($_POST["password"], PASSWORD_DEFAULT));
// $stmt->bindValue(":password", $_POST["password"]);
$stmt->bindValue(":name", $_POST["name"]);
$stmt->bindValue(":email", $_POST["email"]);
$stmt->execute();

// $sql = "UPDATE user_invitations SET activated_at = :activated_at WHERE user_id = :user_id";
// $stmt = $dbh->prepare($sql);
// $stmt->bindValue(":user_id", $user["id"]);
// $stmt->bindValue(":activated_at", (new DateTime())->format('Y-m-d H:i:s'));
// $result = $stmt->execute();


header('Location: /admin/index.php');

?>