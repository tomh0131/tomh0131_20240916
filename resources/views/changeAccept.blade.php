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
        <?php
            $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
            $sql = $pdo->prepare('select * from user where login_id = ? and user_id<>?');
            $sql->execute([$_POST['login_id'] , $_SESSION['user']['user_id']]);
            if(empty($sql->fetchAll())){
                $sql = $pdo->prepare('update user set user_name=? ,login_id=? ,password=? ,mailaddress=? where user_id=?');
                $sql->execute([$_POST['user_name'],$_POST['login_id'],$_POST['password'],$_POST['mailaddress'],$_SESSION['user']['user_id']]);
                $_SESSION['user']=[
                    'name'=>$_POST['user_name'],
                    'email'=>$_POST['mailaddress'],
                    'login_id'=>$_POST['login_id'],
                    'password'=>$_POST['password'],
                    'user_id'=>$_SESSION['user']['user_id']
                ];
                echo '<p>登録情報を更新しました。引き続き当サービスをご利用ください。</p><br>';
                echo '<a href="/qualification/public/top">トップページに戻る</a>';
            }else{
                echo '<p>そのログインIDは別の人に使用されています。別のものにしてください。</p><br>';
                echo '<a href="/qualification/public/change">登録変更ページに戻る</a><br>';
                echo '<a href="/qualification/public/top">トップページに戻る</a>';
            }
        ?>
    </body>
</html>