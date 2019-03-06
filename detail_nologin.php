<?php
session_start();
// 関数ファイルの読み込み
include('functions.php');

// getで送信されたidを取得
$id = $_GET['id'];

//DB接続します
$pdo = db_conn();

//データ登録SQL作成，指定したidのみ表示する
$sql = 'SELECT * FROM therapy_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if ($status==false) {
    // エラーのとき
    errorMsg($stmt);
} else {
    // エラーでないとき
    $rs = $stmt->fetch();
    // fetch()で1レコードを取得して$rsに入れる
    // $rsは配列で返ってくる．$rs["id"], $rs["task"]などで値をとれる
    // var_dump()で見てみよう
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>お悩み症状詳細</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        div{
            padding: 10px;
            font-size:16px;
            }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">お悩み症状詳細</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">LOGIN PAGE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="select_nologin.php">お悩み症状一覧</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- <form method="post" action="update.php"> -->
    <form>
        <div class="form-group">
            <label for="name">お名前</label>
            <input type="text" disabled="disabled" class="form-control" id="name" name="name" placeholder="任意">
        </div>
        <div class="form-group">
            <label for="syndrome">つらい症状</label>
            <input type="text" disabled="disabled" class="form-control" id="syndrome" name="syndrome" placeholder="必須">
        </div>
        <div class="form-group">
            <label for="date">いつから？</label>
            <input type="date" disabled="disabled" class="form-control" id="date" name="date" placeholder="必須">
        </div>
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea disabled="disabled" class="form-control" id="comment" name="comment" rows="2" placeholder="任意"></textarea>
        </div>
        <div class="form-group">
            <label for="upfile">Image</label>
            <input type="file" disabled="disabled" class="form-control" id="upfile" name="upfile" accept="image/*" capture="camera">
            <!-- inputを追加 -->
        </div>
        <!-- idは変えたくない = ユーザーから見えないようにする-->
        <input type="hidden" name="id" value="<?=$rs['id']?>">
    </form>

</body>

</html>