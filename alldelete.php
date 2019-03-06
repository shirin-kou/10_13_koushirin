<?php
session_start();
include('functions.php');
chk_ssid();

$pdo = db_conn();

$spl = 'DELETE FROM therapy_table';//1tableをすべて削除する
$stmt = $pdo->prepare($spl);
$status = $stmt->execute();

//データ登録処理後
if($status==false){
    errorMsg($stmt);
}else{
    header('Location: select.php');
    exit;
}