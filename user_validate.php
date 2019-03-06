<?php
session_start();
include('functions.php');
chk_ssid();

$id=$_GET['id'];
$pdo=db_conn();

//edtypeを無効:1から有効:0に。
$spl = 'UPDATE user_table SET edtype=0 WHERE id=:id';
$stmt = $pdo->prepare($spl);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$statue = $stmt->execute();

//データ登録処理後
if($status==false){
    errorMsg($stmt);
}else{
    //select.phpへリダイレクト
    header('Location: user_select.php');
    exit;
}