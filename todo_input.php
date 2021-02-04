<?php
ini_set('display_errors', "1");
session_start();
include("common.php");
check_session_id();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（入力画面）</title>
</head>

<body>
  <form action="read_act.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>ご感想はこちらから</legend>
      <a href="todo_read.php">一覧画面</a>
      <a href="todo_logout.php">logout</a>
      <div>
        コメント: <input type="text" name="todo">
      </div>
      <div>
        購入日: <input type="date" name="deadline">
      </div>
      <div>
        <input type="file" name="upfile" accept="image/*" capture="camera">
      </div>
      <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>