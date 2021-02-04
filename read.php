<?PHP
// var_dump($_POST);
// exit();
ini_set('display_errors', 1);
session_start();
include('common.php');
check_session_id();

$user_id = $_SESSION["id"];
// var_dump($user_id);
// exit();

// $todo = $_POST['todo'];
// $deadline = $_POST['deadline'];
// var_dump($deadline);
// exit();


$pdo = connect();

// $sql = 'INSERT INTO todo_table(id, todo, deadline, created_at, updated_at) VALUES(NULL, :todo, :deadline, sysdate(), sysdate())';

// var_dump($_sql);
// exit();
// SQL準備&実行
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
// $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
// $status = $stmt->execute();

$username = $_SESSION["username"];

$st = $pdo->query("SELECT * FROM goods");
$goods = $st->fetchAll();

// $username = $_POST['username'];
// $password = $_POST['password'];

// $sql = 'SELECT * FROM users_table
//           WHERE username=:username
//             AND password=:password
//             AND is_deleted=0';

// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':username', $username, PDO::PARAM_STR);
// $stmt->bindValue(':password', $password, PDO::PARAM_STR);
// $status = $stmt->execute();

// $val = $stmt->fetch(PDO::FETCH_ASSOC);

// ここからてすと
$sql = 'SELECT * FROM todo_table LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS cnt FROM like_table GROUP BY todo_id) AS likes ON todo_table.id = likes.todo_id';
$stmt = $pdo->prepare($sql); // 変更なし 
$status = $stmt->execute();

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
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
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {
        $output .= "<tr>";

        $output .= "<td>{$record["deadline"]}</td>";
        $output .= "<td>{$record["todo"]}</td>";
        $output .= "<td><img src='{$record["image"]}' height=150px></td>";
        // edit deleteリンクを追加
        $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>いいね</a><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>{$record["cnt"]}</a>
</td>";
        // cntカラムの数値(いいね数)を追加

        $output .= "<td><a href='todo_edit.php?id={$record["id"]}'>修正</a></td>";
        $output .= "<td><a href='todo_delete.php?id={$record["id"]}'>削除</a></td>";

        $output .= "</tr>";
    }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>福岡エビス</title>
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="main_sec.css">


</head>

<body>
    <header>

        <div class="inner">
            <h1 class="logo"> 福岡エビス</h1>
            <h2 class="welcom">
                ようこそ
                <?= $username ?>さん
            </h2>



        </div>
    </header>
    <!-- ここからハンバーガーメニュー入れてみる -->
    <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="top">
        <img class="topimage" src="shizuoka.jpg" alt="">
    </div>
    <nav class="globalMenuSp">
        <ul>
            <li><a href="#company">福岡エビスについて</a></li>
            <li><a href="#product">商品のご案内</a></li>
            <li><a href="#howto">商品の使い方</a></li>
            <li><a href="#company_profile">会社概要</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li><a href="logout.php">ログアウト</a></li>
            <li><a href="mypage.php">マイページ</a></li>
        </ul>
    </nav>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <script>
        $(function() {
            $('.hamburger').click(function() {
                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    $('.globalMenuSp').addClass('active');
                    // $('body').addClass('overflowHidden');
                } else {
                    $('.globalMenuSp').removeClass('active');
                    // $('body').removeClass('overflowHidden');
                }
            });
        });


        // Resources
    </script>


</body>

</html>
<!-- ここまで -->

<!-- ここから検索いれてみる -->
<fieldset>
    <legend>リアルタイム検索型todoリスト</legend>
    <a href="ajax_input.php">入力画面</a>
    <div>
        検索フォーム：<input type="text" id="search">
    </div>
    <table>
        <thead>
            <tr>
                <th>deadline</th>
                <th>todo</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="result">
            <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        </tbody>
    </table>
</fieldset>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $('#search').on('keyup', function() {
        // console.log($(this).val());
        const serchWord = $(this).val();
        const requestUrl = 'ajax_get.php';


        axios.get(`${requestUrl}?serchword=${serchWord}`)
            .then(function(response) {
                console.log(response);
                //#textにtodoテーブルのtodoのデータをinsertAdjacentHTMLで表示させる


                const output = [];






                response.data.forEach(function(x) {
                    output.push(`<tr><td>${x.todo}<td><tr>`)

                });
                $('#result').html(output);
            })
            .catch(function(error) {})
            // console.log(error);
            .finally(function() {});


    });


    //次に#searchに入力されるたびにデータの表示を変える処理自体はうえとほぼ同じ
    // $('#search').on('keyup', function() {
    //     // console.log($(this).val()); // inputの内容をリアルタイムに取得
    //     const serchWord = $(this).val();
    //     const requestUrl = 'ajax_get.php'; // リクエスト送信先のファイル
    //     // phpへリクエストを送って結果を出力する処理
    //     axios.get(`${requestUrl}?serchword=${serchWord}`) // リクエスト送信
    //         .then(function(response) {
    //             // console.log(response); // responseにPHPから送られたデータが入る
    //             //入力のたびに一度空にする
    //             $('#text').html('');
    //             response.data.forEach(res => {
    //                 document.getElementById('text').insertAdjacentHTML('beforeend', `<p>${id.todo}</p>`);
    //             });
    //         })
    //         .catch(function(error) {})
    //         .finally(function() {});
    // });
</script>
<!-- ここまで -->

<h1 id="company">福岡エビスについて</h1>
<img src="logo.jpg" id="logo" alt="">
<div class="consept">
    <p>当社は設立より約２０年ポット・急須用品の製造を行っています。</p>
    <p>主に茶こし、急須のつる、急須口のチューブなどを製造・販売しています。</p>
    <p>プラスチック加工製造機を導入し、茶こしとプラスチックのコラボレーション製品も製造しています。</p>
    <p>お客様のアイディアをお聞きし、金型を作成しプラスチックやステンレスを使用し製品化することも可能です。</p>
    <p>是非何かあれば当社にご相談ください。</p>
</div>


<h1 id="product">商品のご案内</h1>

<table>

    <?php foreach ($goods as $g) {

    ?>
        <tr>
            <td>
                <?php echo img_tag($g['code']) ?>
            </td>
            <td>
                <p class="goods"><?php echo $g['name'] ?></p>
                <p><?php echo nl2br($g['comment']) ?></p>
            </td>
            <td width="80">
                <p><?php echo $g['price'] ?> 円</p>
                <form action="cart.php" method="post">
                    <select name="num">
                        <?php
                        for ($i = 0; $i <= 9; $i++) {
                            echo "<option>$i</option>";
                        } ?>


                    </select>
                    <input type="hidden" name="code" value="<?php echo $g['code'] ?>">
                    <input type="submit" name="submit" value="カートへ">



                </form>
            </td>
        </tr>
    <?php } ?>

</table>

<table>

    <h1 id="voice">ご感想</h1>

    <div class="coment">
        <a href="todo_input.php">コメントはこちらから</a>
    </div>
    <?= $output ?>
</table>



<h1 id="howto">商品の使い方</h1>
<div class="row">
    <p class="txt-warning">※音が出ます。音量にお気をつけください</p>
    <video class="cm-movie" src="images/ochaco720p.m4v" preload="metadata" controls></video>


</div>

<div class="company_info">

    <h1 id="company_profile">会社概要</h1>
    <p class="companyname">福岡エビス</p> <br>
    <p>
        本社<br>
        〒819-0731<br>
        福岡県福岡市西区飯氏958-3
    </p>
    <p>
        広川工場<br>
        〒834-0111<br>
        福岡県八女郡広川町大字日吉356-1
    </p>


</div>


<h1 id="contact">お問合わせ</h1>

<div class="Form">
    <div class="Form-Item">
        <p class="Form-Item-Label">
            <span class="Form-Item-Label-Required">必須</span>会社名
        </p>
        <input type="text" class="Form-Item-Input" placeholder="例）株式会社令和">
    </div>
    <div class="Form-Item">
        <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>氏名</p>
        <input type="text" class="Form-Item-Input" placeholder="例）山田太郎">
    </div>
    <div class="Form-Item">
        <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>電話番号</p>
        <input type="text" class="Form-Item-Input" placeholder="例）000-0000-0000">
    </div>
    <div class="Form-Item">
        <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>メールアドレス</p>
        <input type="email" class="Form-Item-Input" placeholder="例）example@gmail.com">
    </div>
    <div class="Form-Item">
        <p class="Form-Item-Label isMsg"><span class="Form-Item-Label-Required">必須</span>お問い合わせ内容</p>
        <textarea class="Form-Item-Textarea"></textarea>
    </div>
    <input type="submit" class="Form-Btn" value="送信する">
</div>
<footer>
    <div class="inner">
        <p class="copyright">©️2020福岡エビス.</p>

    </div>
</footer>
</body>


</html>