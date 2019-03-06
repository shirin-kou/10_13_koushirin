<?php
session_start();
include('functions.php');

//入力チェック(受信確認処理追加)
if (
    !isset($_POST['syndrome']) || $_POST['syndrome']=='' ||
    !isset($_POST['date']) || $_POST['date']==''
) {
    exit('ParamError');
}

chk_ssid();

//POSTデータ取得
$id = $_POST['id'];
$name = $_POST['name'];
$syndrome = $_POST['syndrome'];
$date = $_POST['date'];
$comment = $_POST['comment'];
$file_name = $_POST['image'];

//DB接続します(エラー処理追加)
$pdo = db_conn();

//データ登録SQL作成
$sql = 'UPDATE therapy_table SET name=:a1, syndrome=:a2, date=:a3, comment=:a4, image=:image WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $syndrome, PDO::PARAM_STR);
$stmt->bindValue(':a3', $date, PDO::PARAM_STR);
$stmt->bindValue(':a4', $comment, PDO::PARAM_STR);
$stmt->bindValue(':image', $file_name, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: select.php');
    exit;
}

//写真のUPDATEがまだ出来てない。190304
