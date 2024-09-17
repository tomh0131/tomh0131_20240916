<?php session_start(); ?>
<p?php 
    if(isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }
?>
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
            <h1>My資格管理ログイン</h1>
            <form action="/qualification/public/top" method="post">
                @csrf
                <p>ログインID：<input type="text" name="login_id" required></p>
                <p>パスワード：<input type="password" name="password" required></p>
                <input type="submit" value="ログイン">
            </form>
            <p>登録がお済みでない方は<a href="/qualification/public/resistration">こちら</a>から新規登録してください</p>
    </body>
</html>
