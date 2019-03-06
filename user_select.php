<?php
//1. DB接続  insert.phpと同じ
session_start();
include('functions.php');
chk_ssid();
$pdo = db_conn();

$menu = menu_kanri();

//+++++ SQL文におけるバッファを有効にする。+++++
//gs_bm_table表の行数を数えるための処理のために必要。
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);


//2. データ表示SQL作成
$sql = 'SELECT * FROM user_table ORDER BY edtype';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//therapy_table表の全行数を数えるための処理。
$result=$pdo->query($spl);
$result->execute();
$all_row_cnt=$result->rowCount();

$stmt_flg0=$pdo->prepare("SELECT * from user_table where edtype=0");
$status_flg0=$stmt_flg0->execute();

$result_flg0_num=$pdo->query("SELECT * from user_table where edtype=0");
$lf0_row_cnt=$result_flg0_num->rowCount();

$stmt_flg1=$pdo->prepare("SELECT * from user_table where edtype=1");
$status_flg1=$stmt_flg1->execute();

$result_flg1_num=$pdo->query("SELECT * from user_table where edtype=1");
$lf1_row_cnt=$result_flg1_num->rowCount();

//3. データ表示(edtype=0の場合)
$view_flg0='';
if ($status_flg0==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt_flg0->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    //selectデータの数だけ自動でループしてくれる
    //2件以上登録されている場合に全削除ボタンを表示
    if($lf0_row_cnt>1){
        $view_flg0 .= '<a href="javascript:void(0);" onclick="var ok=confirm(\'本当にすべてを無効にしますか？\'); if(ok) location.href=\'user_alldelete.php\'; return false;" class="badge badge-danger">ALL Invalidate</a>';
    }
    if($lf0_row_cnt==0){
        $view_flg0 .= '<h7>現在使用されている（有効な）ユーザはありません。</h7>';
    }
    while($result2 = $stmt_flg0->fetch(PDO::FETCH_ASSOC)) {
        $view_flg0 .= '<li class="list-group-item">';
        $view_flg0 .= '<p>'.$result2['username'].'---'.$result2['lid'].'---'.$result2['lpw'].'</p>';
        $view_flg0 .= '<a href="user_detail.php?id='.$result2['id'].'" class="badge badge-primary">EDIT</a>';
        $view_flg0 .= '<a href="javascript:void(0);" onclick="var ok=confirm(\'本当に無効にしますか？\'); if(ok) location.href=\'user_delete.php?id='.$result2['id'].'\'; return false;" class="badge badge-danger">Invalidate</a>';
        $view_flg0 .= '</li>';
    }

    //2件以上登録されている場合に全削除ボタンを表示
    if($lf0_row_cnt>1){
        $view_flg0 .= '<a href="javascript:void(0);" onclick="var ok=confirm(\'本当にすべてを無効にしますか？\'); if(ok) location.href=\'user_alldelete.php\'; return false;" class="badge badge-denger">All Invalidate</a>';

    }
}

//3. データ表示(edtype=1の場合)
$view_flg1='';
if($status_flg1==false){
    //execuse（SQL実行時にエラーがある場合）
    $error = $stmt_flg1->errorInfo();
    exit('sqlError:'.$error[2]);
}else{
    //selectデータの数だけ自動でループしてくれる
    if($lf1_row_cnt==0){
        $view_flg1 .= '<h7>現在使用されていない（無効な）ユーザはありません。</h7>';
    }
    while($result3 = $stmt_flg1->fetch(PDO::FETCH_ASSOC)){
        $view_flg1 .= '<li class="list-group-item">';
        $view_flg1 .= '<p>'.$result3['username'].'---'.$result3['lid'].'---'.$result3['lpw'].'</p>';
        $view_flg1 .= '<a href="user_detail.php?id='.$result3['id'].'" class="badge-badge-primary">EDIT</a>';
        $view_flg1 .= '<a href="javascript:void(0);" onclick="var ok=confirm(\`本当に有効にしますか？\`); if (ok) location.href=\'user_validate.php?id='.$result3['id'].'\'; return false;" class="badge-badge-danger">Validate</a>';
        $view_flg1 .= '</li>';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザ登録とユーザ一覧表示</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">ユーザ一覧</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?=$menu?>
                </ul>                               
            </div>
        </nav>
    </header>
    <br>
    <h6>◆使用されている（有効な）ユーザ</h6>
    <div>
        <ul class="list-group">
            <?=$view_flg0?>
        </ul>
    </div>
    <br>
    <h6>◆使用されていない（無効な）ユーザ</h6>
    <div>
        <ul class="list-group">
            <?=$view_flg1?>
        </ul>
    </div>

</body>

</html>