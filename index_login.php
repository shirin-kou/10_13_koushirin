<?php
//セッションのスタート
session_start();

//外部ファイル読み込み
include('functions.php');

//ログイン状態を確認
chk_ssid();

//上部メニュー部分をkanri_flgにより決定する
if($_SESSION['utype']==0){
    $menu = manu();
}else{
    $menu = menu_kanri();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8mb4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>お悩み症状</title>
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
            <a class="navbar-brand" href="#">お悩み症状登録</a>
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

    <!-- 必要な属性を追加 -->
    <form method="post" action="insert_file.php">
        <div class="form-group">
            <label for="name">お名前をお教えください（ニックネームでも可）。</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="任意">
        </div>
        <div class="form-group">
            <label for="syndrome">お悩み症状は何ですか？</label>
            <input type="text" class="form-control" id="syndrome" name="syndrome" placeholder="必須">
        </div>
        <div class="form-group">
            <label for="date">症状はいつ発症しましたか？</label>
            <input type="date" class="form-control" id="date" name="date" placeholder="必須">
        </div>
        <div class="form-group">
            <label for="comment">ご自由にご記入ください。</label>
            <textarea class="form-control" id="comment" name="comment" rows="2" placeholder="任意"></textarea>
        </div>
        <div class="form-group">
            <label for="upfile">ケガまたは皮ふ疾患にお悩みでしたら、患部の写真をアップロードしてください。</label>
            <input type="file" class="form-control" id="upfile" name="upfile" accept="image/*" capture="camera">
            <!-- inputを追加 -->
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">送信</button>
        </div>
    </form>

</body>

</html>
