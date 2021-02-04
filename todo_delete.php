<?php
// var_dump($_GET);
// exit();
ini_set('display_errors', 1);
session_start();
include("common.php");

// 送信されたidをgetで受け取る 
$id = $_GET['id'];


$pdo = connect();
// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'DELETE FROM todo_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

// fetch()で1レコード取得できる. 
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header('Location:read.php');
}
