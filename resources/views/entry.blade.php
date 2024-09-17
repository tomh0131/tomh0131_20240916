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
        <h1>My資格管理</h1>
    <?php 
            $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
            $sql = $pdo->prepare('select * from user where login_id = ? ');
            $sql->execute([$_REQUEST['login_id']]);

            if(empty($sql->fetchAll())){
                if(isset($_POST['mailaddress'])){
                    $sql = $pdo->prepare('insert into user values(null,?,?,?,?)');
                    $sql->execute([$_POST['user_name'],$_POST['login_id'],$_POST['password'],$_POST['mailaddress']]);
                }else{
                    $sql = $pdo->prepare('insert into user values(null,?,?,?)');
                    $sql->execute([$_POST['user_name'],$_POST['login_id'],$_POST['password']]);
                }
                echo '<p>'.$_POST['user_name'].'様、ご登録ありがとうございます。<br><a href="/qualification/public/">こちら</a>からサービスをご利用ください。</p>';
            }else{
                echo '<p>そのログインIDは既に使用されています。別のものにしてください。</p>';
                echo '<a href="/qualification/public/resistration">新規登録ページへ戻る</a>';
            }

        ?>
    </body>
</html>
