<?php
//共通で使うものを別ファイルにしておきましょう。

//DB接続関数（PDO）
function db_conn()
{
    $dbn = 'mysql:dbname=gs_f02_db13;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = 'root';
    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        exit('dbError:'.$e->getMessage());
    }
}

//SQL処理エラー
function errorMsg($stmt)
{
    $error = $stmt->errorInfo();
    exit('ErrorQuery:'.$error[2]);
}

//SESSIONチェック＆リジェネレイト
function chk_ssid()
{
    //ログイン失敗時の処理（ログイン画面に移動）
    if(!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid']!=session_id()){
        header('Location:login.php');
    }//ログイン成功時の処理（一覧画面の移動）
    else{
        session_regenerate_id(true);//sessionIDの再生成
        $_SESSION['chk_ssid'] = session_id();//session変数に格納。myadminのIDとは別。
    }
}

//menuを決める
function menu()
{
    $menu = '<li class="nav-item"><a class="nav-link" href="index_login.php">登録</a></li><li class="nav-item"><a class="nav-link" href="select.php">一覧</a></li>';
    $menu .= '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
    // $menu .= '<li class="nav-item">'.$_SESSION['name'].'でログイン中</li>';
    return $menu;
}

function menu_kanri()
{
    $menu = '<li class="nav-item"><a class="nav-link" href="index_login.php">登録</a></li><li class="nav-item"><a class="nav-link" href="select.php">一覧</a></li>';
    $menu .= '<li class="nav-item"><a class="nav-link" href="user_index.php">ユーザ登録</a></li><li class="nav-item"><a class="nav-link" href="user_select.php">ユーザ管理・一覧</a></li>';
    $menu .= '<li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>';
    // $menu .= '<li class="nav-item">'.$_SESSION['name'].'でログイン中</li>';
    return $menu;
}
