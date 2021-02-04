<?php
// session_start();

function connect()
{
    return new PDO("mysql:dbname=gsacf_d07_12", "root");
}

function img_tag($code)
{
    if (file_exists("images/$code.jpg")) $name = $code;
    else $name = 'noimage';
    return '<img src="images/' . $name . '.jpg" alt="">';
}



// ログイン状態のチェック関数
function check_session_id()
{
    // 失敗時はログイン画面に戻る
    if (
        !isset($_SESSION['session_id']) || // session_idがない
        $_SESSION['session_id'] != session_id() // idが一致しない 
    ) {
        header('Location: login.php');
        // ログイン画面へ移動 
    } else {
        session_regenerate_id(true); // セッションidの再生成
        $_SESSION['session_id'] = session_id(); // セッション変数上書き }
    }
}
