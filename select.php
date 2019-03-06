<?php
session_start();

include('functions.php');
chk_ssid();

//DB接続
$pdo = db_conn();

if($_SESSION['utype']==0){
    $menu = menu();
}else{
    $menu = menu_kanri();
}

//一般ログイン（utype=0)の時にトップメニューからindex.pph（登録）に移動できない。
//一覧、ログアウトはできた。190306

$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

//データ表示SQL作成
$sql = 'SELECT * FROM therapy_table';
// $sql = 'SELECT * FROM therapy_table ORDER BY deadline DESC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//表の行数を数えるための処理。
$result=$pdo->query($sql);
$result->execute();
$row_cnt=$result->rowCount();

//データ表示
$view='';
if ($status==false) {
    $error=$stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    if($row_cnt>1){
        $view .= '<a href="javascript:void(0);" onclick="var ok=confirm(\`本当にすべて削除しますか？\`); if (ok) location.href=\`alldelete.php\`; return false;" class="badge badge-danger">ALL Delete</a>';
    }    
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<li class="list-group-item">';
        $view .= '<p>'.$result['name'].'-'.$result['syndrome'].'-'.$result['date'].'</p>';
        $view .= '<p>'.$result['comment'].'</p>';
        $view .= '<img src="'.$result['image'].'" alt="" height="150px">';
        // imgタグで出力しよう！
        $view .= '<div><a href="detail.php?id='.$result[id].'" class="badge badge-primary">Edit</a>';
        $view .= '<a href="javascript:void(0);" onclick="var ok=confirm(\'本当に削除しますか？\'); if (ok) location.href=\'delete.php?id='.$result['id'].'\'; return false;" class="badge badge-danger">Delete</a></div>';
        // $view .= '<a href="delete.php?id='.$result[id].'" class="badge badge-danger">Delete</a></div>';
        $view .= '</li>';
    }

}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>お悩み症状一覧</title>
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
            <a class="navbar-brand" href="#">お悩み症状一覧</a>
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

    <div>
        <ul class="list-group">
            <?=$view?>
        </ul>
    </div>

</body>

</html>