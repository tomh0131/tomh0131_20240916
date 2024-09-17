<?php session_start(); ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>qualification management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialiased">
        <h1>My資格管理 登録情報の変更</h1>
        <form action="/qualification/public/accept" method="post">
                @csrf
                <?php 
                    echo '<p>ユーザ名<span class="important">(必須)</span>：<input type="text" name="user_name" value="'.$_SESSION['user']['name'].'" required></p>';
                    echo '<p>ログインID<span class="important">(必須)</span>：<input type="text" name="login_id" value="'.$_SESSION['user']['login_id'].'" required></p>';
                    echo '<p>パスワード<span class="important">(必須)</span>：<input type="password" name="password" value="'.$_SESSION['user']['password'].'" required></p>';
                    // echo '<p>メールアドレス：<input type="email" name="mailaddress" value="'.$_SESSION['user']['email'].'"></p>';
                ?>
                <input type="submit" value="変更する">
                <!-- <p>メールアドレスは資格受験日、資格更新時期のアラートにのみ使用します。</p> -->
            </form>
    </body>
</html>
