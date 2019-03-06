<?php
session_start();

if (
    !isset($_POST['username']) || $_POST['username']=='' ||
    !isset($_POST['lid']) || $_POST['lid']=='' ||
    !isset($_POST['lpw']) || $_POST['lpw']==''
) {
    exit('ParamError');
}

include('functions.php');
chk_ssid();

//POSTデータ取得
$username = $_POST['username'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$utype = $_POST['utype'];
$edtype = $_POST['edtype'];

$pdo = db_conn();

//データ登録SQL作成
// $sql='INSERT INTO user_table values (null,:a1,:a2,:a3,:a4,:a5)';

$sql ='INSERT INTO user_table(id, username, lid, lpw, utype, edtype)
VALUES(NULL, :a1, :a2, :a3, :a4, :a5)';

$stmt = $pdo->prepare($spl);
$stmt->bindValue(':a1', $username, PDO::PARAM_STR);
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':a4', $utype, PDO::PARAM_INT);
$stmt->bindValue(':a5', $edtype, PDO::PARAM_INT);
$status = $stmt->execute();

//テーブルをユーザごとに作成
// $spl2='CREATE TABLE IF NOT EXISTS `therapy_table_'.username.'`(
//     `id` int(11) NOT NULL,
//     `name` varchar(64) NOT NULL,
//     `syndrome` text NOT NULL,
//     `date` date NOT NULL,
//     `comment` text NOT NULL,
//     `image` varchar(128) NOT NULL,
//     INDEX(id)
// )ENGINE=InnoDB DEFAULT CHARSET=utf8';
// $stmt2=$pdo->prepare($spl2);
// $status2=$stmt2->execute();

//データ登録後処理
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error=$stmt->errorInfo();
    exit('sqlError:'.$error[2]);
}else{
    header('Location:user_select.php');
}


//データ登録処理後
// if ($status==false) {
//     errorMsg($stmt);
// } else {
//     //index.phpへリダイレクト
//     header('Location: user_select.php');
// }
