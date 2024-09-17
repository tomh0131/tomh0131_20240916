<?php session_start();?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>qualification management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            /* .flex{
                display: flex;
            } */
            .important{
                color: red;
                font: bold;
            }
            .block{
                display: block;
            }
        </style>
    </head>
    <body class="antialiased">
        <?php
            $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");

            echo '<h1>My資格管理 所持資格一覧</h1>';
            echo $_SESSION['user']['name'].'さんの所持資格一覧です。<hr>';
            if(!isset($_POST['command'])){

            }else if($_POST['command']==='update'){
                $sql = $pdo->prepare('update users_qualification set expiration = ? ,announce_date = ?,announce_flag = ?,add_info = ? where user_id=? and qual_id=? and passed_date =?');
                $sql->execute([$_POST['expiration'],$_POST['announce_date'],$_POST['announce_flag'],$_POST['add_info'],$_SESSION['user']['user_id'],$_POST['qual_id'],$_POST['passed_date']]);
                echo '登録されていた資格情報を更新しました。<hr>';
            }else if($_POST['command']==='delete'){
                $sql = $pdo->prepare('update users_qualification set delete_flag = "1" where user_id=? and qual_id=? and passed_date=?');
                $sql->execute([$_SESSION['user']['user_id'],$_POST['qual_id'],$_POST['passed_date']]);
                echo '指定した資格の登録情報を削除しました。<hr>';
            }
                    
            //コンテンツをここに記載
            $sql = $pdo->prepare('select T1.qual_id,T2.qual_name,T1.passed_date,T1.expiration,T1.announce_date,T1.announce_flag,T1.add_info from users_qualification AS T1 INNER JOIN all_qualification AS T2 ON T1.qual_id = T2.qual_id where T1.user_id = ? and delete_flag <>"1"');
            $sql ->execute([$_SESSION['user']['user_id']]);

            foreach($sql as $row){
                echo '<div class="flex">';
                echo '<form action="/qualification/public/qualification" method="post">';
                echo '<input type="hidden" name="command" value="update">';
                echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
                echo '<input type="hidden" name="qual_id" value="'.$row['qual_id'].'">';
                echo '<input type="hidden" name="passed_date" value="'.$row['passed_date'].'">';
                echo '資格名：<span class="important"> '.$row['qual_name'].' </span>';
                echo '合格日：'.$row['passed_date'].' <br>';
                echo '更新期限：<input type="date" name="expiration" value="'.$row['expiration'].'" > ';
                echo '連絡日：<input type="date" name="announce_date" value="'.$row['announce_date'].'" > ';
                $cq1='';
                $cq0='';
                if($row['announce_flag']=="1"){
                    $cq1=' checked';
                }else{
                    $cq0=' checked';
                }
                echo '連絡：<input type="radio" name="announce_flag" value="1"'.$cq1.'>する<input type="radio" name="announce_flag" value="0"'.$cq0.'>しない<br>';
                echo '自由入力：<input type="text" name="add_info" value="'.$row['add_info'].'">';

                echo '<input type="submit" class="block" value="更新">';
                echo '</form>';
                
                echo '<form action="/qualification/public/qualification" method="post">';
                echo '<input type="hidden" name="command" value="delete">';
                echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
                echo '<input type="hidden" name="qual_id" value="'.$row['qual_id'].'">';
                echo '<input type="hidden" name="passed_date" value="'.$row['passed_date'].'">';
                echo '<input type="submit" value="削除">';
                echo '</form>';
                echo '</div><hr>';
            }

            echo '<p><a href="/qualification/public/top">資格管理トップ</a></p>';
            echo '<p><a href="/qualification/public/qual_entry">所持資格新規登録</a></p>';
            echo '<p><a href="/qualification/public/expected_qual">受検予定資格登録・修正</a></p>';

            echo '<a href="/qualification/public/">ログアウト</a>';
        ?>
    </body>
</html>