<?php
session_start();
include('functions.php');
chk_ssid();

//入力チェック（情報確認処理追加）
if(
    !isset($_POST['username']) || $_POST['username']==''
){
    $username = $_POST['username'];
    exit('ParamError');
}

//POSTデータ取得
$id = $_POST['id'];
$username = $_POST['username'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//DB接続
$pdo = db_conn();

//データ登録SQL作成
$sql = 'UPDATE user_table SET username=:a1, lid=:a2, lpw=:a3 WHERE id=:id';
$stmt = $pdo->$prepare($sql);
$stmt->bindValue(':a1'. $username, PDO::PARAM_STR);
$stmt->bindValue(':a2'. $lid, PDO::PARAM_STR);
$stmt->bindValue(':a3'. $lpw, PDO::PARAM_STR);
$stmt->bindValue(':id'. $id, PDO::PARAm_INT);
$statue = $stmt->execute();

//データ登録処理後
if($status==false){
    errorMsg($stmt);
}else{
    header('Location:user_select.php');
    exit;
}