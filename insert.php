<?php

session_start();

// 入力チェック
if (
    !isset($_POST['syndrome']) || $_POST['syndrome']=='' ||
    !isset($_POST['date']) || $_POST['date']==''
) {
    exit('ParamError');
}
include('functions.php');
chk_ssid();

//POSTデータ取得
$name = $_POST['name'];
$syndrome = $_POST['syndrome'];
$date = $_POST['date'];
$comment = $_POST['comment'];

//DB接続
$pdo = db_conn();

$sql ='INSERT INTO therapy_table(id, name, syndrome, date, comment, indate) VALUES(NULL, :a1, :a2, :a3, :a4, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $syndrome, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $date, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//データ登録処理後
if ($status==false) {
    errorMsg($stmt);
} else {
    //select.phpへリダイレクト
    header('Location: select.php');
}
