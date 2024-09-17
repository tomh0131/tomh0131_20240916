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
            if(isset($_POST['login_id'])&&isset($_POST['password'])) {
                $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
                $sql = $pdo->prepare('select * from user where login_id = ? and password = ?');
                $sql->execute([$_POST['login_id'],$_POST['password']]);
                foreach($sql as $row){
                    $_SESSION['user'] = [
                        'user_id'=>$row['user_id'],
                        'name'=>$row['user_name'],
                        'email'=>$row['mailaddress'],
                        'login_id'=>$row['login_id'],
                        'password'=>$row['password']
                    ];
                }
            }
            date_default_timezone_set('Japan');
            $today = date('Y-m-d');

            if(isset($_SESSION['user'])){
                echo '<h1>My資格管理トップ</h1>';
                echo 'ようこそ，'.$_SESSION['user']['name'].'さん！';
                
                $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
                $sql = $pdo->prepare('select T1.qual_id,T2.qual_name from expected_qualification AS T1 INNER JOIN all_qualification AS T2 ON T1.qual_id = T2.qual_id where T1.user_id = ? and exam_date =? and T1.announce_flag ="1"');
                $sql ->execute([$_SESSION['user']['user_id'],$today]);
                foreach($sql as $row){
                    echo '今日は<span class="important"> '.$row['qual_name'].' </span>の試験日です！ご武運を祈ります！<hr>';
                }

                $sql = $pdo->prepare('select T1.qual_id,T2.qual_name from users_qualification AS T1 INNER JOIN all_qualification AS T2 ON T1.qual_id = T2.qual_id where T1.user_id = ? and delete_flag <>"1"and T1.announce_date=? and T1.announce_flag ="1"');
                $sql ->execute([$_SESSION['user']['user_id'],$today]);
                foreach($sql as $row){
                    echo 'そろそろ<span class="important"> '.$row['qual_name'].' </span>の更新日が近づいてきました！お忘れなく！<hr>';
                }
                //コンテンツをここに記載
                //試験当日の場合はここにどの試験の受検日なのかのアナウンスを、更新のアナウンスの場合はもうすぐ資格の更新日ですというアナウンスをする。

                echo '<p><a href="/qualification/public/change">登録情報の変更</a></p>';
                echo '<p><a href="/qualification/public/qualification">所持資格一覧及び登録情報修正</a></p>';
                echo '<p><a href="/qualification/public/qual_entry">所持資格新規登録</a></p>';
                echo '<p><a href="/qualification/public/expected_qual">受検予定資格登録・修正</a></p>';

                echo '<a href="/qualification/public/">ログアウト</a>';
            }else{
                echo 'ログイン名またはパスワードが違います。';
            }

        ?>
    </body>
</html>
