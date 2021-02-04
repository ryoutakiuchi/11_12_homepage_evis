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
            <li><a href="login.php">ログイン</a></li>
            <li><a href="#login_contact">会員登録</a></li>
        </ul>
    </nav>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <script>
        $(function() {
            $('.hamburger').click(function() {
                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    $('.globalMenuSp').addClass('active');
                } else {
                    $('.globalMenuSp').removeClass('active');
                }
            });
        });


        // Resources
    </script>


</body>

</html>
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
    <?php foreach ($goods as $g) { ?>
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
                        }
                        ?>
                    </select>
                    <input type="hidden" name="code" value="<?php echo $g['code'] ?>">
                    <input type="submit" name="submit" value="カートへ">
                </form>
            </td>
        </tr>
    <?php } ?>
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