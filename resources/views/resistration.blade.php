<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>qualification management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            .important{
                color: red;
                font: bold;
            }
        </style>
    </head>
    <body class="antialiased">
    <h1>My資格管理　新規登録</h1>
            <form action="/qualification/public/entry" method="post">
                @csrf
                <p>ユーザ名<span class="important">(必須)</span>：<input type="text" name="user_name" required></p>
                <p>ログインID<span class="important">(必須)</span>：<input type="text" name="login_id" required></p>
                <p>パスワード<span class="important">(必須)</span>：<input type="password" name="password" required></p>
                <!-- <p>メールアドレス：<input type="email" name="mailaddress"></p> -->
                <input type="submit" value="新規登録">
                <!-- <p>メールアドレスは資格受験日、資格更新時期のアラートにのみ使用します。</p> -->
            </form>
    </body>
</html>
