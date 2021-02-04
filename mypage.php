<?php
// var_dump($_POST);
// exit();
// ↑そもそもmypag.phpには何も送られてない？よね？



session_start();
include('common.php');
check_session_id();

$id = $_GET["id"];
$pdo = connect();
// ↑これでデータベースにはつないでいる（つもり）


// データ受け取り
$username = $_POST["username"];

$password = $_POST["password"];
// var_dump($_POST);
// exit();



$sql = 'SELECT * FROM users_table WHERE id=:id';
// var_dump($sql);
// exit();

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();



// var_dump($id);
// exit();

if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";

    // var_dump($output);
    // exit();

    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["username"]}</td>";
        $output .= "<td>{$record["password"]}</td>";
        // edit deleteリンクを追加
        // var_dump($record);
        // exit();


        $output .= "<td><a href='edit.php?id={$record["id"]}'>edit</a></td>";
        $output .= "<td><a href='delete.php?id={$record["id"]}'>delete</a></td>";
        $output .= "</tr>";
    }
    // var_dump($record);
    // exit();

    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}













?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>マイページ</h1>
    <p>ユーザー名</p>
    <p>パスワード</p>
</body>

</html>