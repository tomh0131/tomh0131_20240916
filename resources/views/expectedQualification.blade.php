<?php session_start();?>
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
            
            echo '<h1>My資格管理 受検予定資格一覧</h1>';
            echo $_SESSION['user']['name'].'さんの受検予定資格一覧です。<hr>';
            date_default_timezone_set('Japan');
            $today = date('Y-m-d');
            $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
            $sql = $pdo->prepare('select T1.qual_id,T2.qual_name,T1.exam_date,T1.result,T1.announce_flag from expected_qualification AS T1 INNER JOIN all_qualification AS T2 ON T1.qual_id = T2.qual_id where T1.user_id = ? and exam_date >=?');
            $sql ->execute([$_SESSION['user']['user_id'],$today]);

            foreach($sql as $row){
                echo '<div class="flex">';
                echo '<form action="/qualification/public/expected_qual" method="post">';
                echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
                echo '<input type="hidden" name="qual_id" value="'.$row['qual_id'].'">';
                echo '資格名：<span class="important"> '.$row['qual_name'].' </span>';
                echo '受検日：'.$row['exam_date'].' <br>';
                // echo '結果：<input type="radio" name="result" value="1">合格<input type="radio" name="result" value="0">不合格 ';
                $cq1='';
                $cq0='';
                if($row['announce_flag']=="1"){
                    $cq1=' checked';
                }else{
                    $cq0=' checked';
                }
                echo '連絡：<input type="radio" name="announce_flag" value="1"'.$cq1.'>する<input type="radio" name="announce_flag" value="0"'.$cq0.'>しない<br>';
                echo '<input type="submit" class="block" value="更新">';
                echo '</form>';

                echo '</div><hr>';
            }
        
            //コンテンツをここに記載
        ?>
        <form action="/qualification/public/expected_qual" method="post">
            @csrf
            <p>カテゴリーから検索して追加する</p>
            <select name="category">
                <option value="0">農林水産技術</option>
                <option value="1">食品技術</option>
                <option value="2">鉱工業技術</option>
                <option value="3">建築技術</option>
                <option value="4">土木・測量技術</option>
                <option value="5">情報処理技術</option>
                <option value="6">その他の技術</option>
                <option value="7">医師、歯科医師、獣医師、薬剤師</option>
                <option value="8">保健師、助産師、看護師</option>
                <option value="9">医療技術職</option>
                <option value="10">栄養士</option>
                <option value="11">物療専門職</option>
                <option value="12">その他の医療・保健衛生</option>
                <option value="13">福祉・介護</option>
                <option value="14">法務</option>
                <option value="15">経営</option>
                <option value="16">幼稚園・学校教諭免許</option>
                <option value="17">博物館・図書館専門職</option>
                <option value="18">専修・各種学校教員</option>
                <option value="19">スポーツ等指導</option>
                <option value="20">美術・音楽等</option>
                <option value="21">カウンセリング</option>
                <option value="22">不動産関連</option>
                <option value="23">翻訳・語学</option>
                <option value="24">秘書技能</option>
            </select>
            <input type="submit" value="カテゴリーで検索する">
        </form>
        <p>カテゴリーについてはハローワークのページを参照：<a href="https://www.hellowork.mhlw.go.jp/info/license_list03.html">外部リンク</a></p><hr>
        <form action="/qualification/public/expected_qual" method="post">
            @csrf
            <p>資格名から検索して追加する</p>
            <p>資格名の数字は全角で入力してください。</p>
            <input type="text" name="keyword">
            <input type="submit" value="資格名で検索する">
        </form><hr>
        <?php
                if(isset($_POST['category'])){
                    $array = ['農林水産技術','食品技術','鉱工業技術','建築技術','土木・測量技術',
                    '情報処理技術','その他の技術','医師、歯科医師、獣医師、薬剤師','保健師、助産師、看護師','医療技術職',
                    '栄養士','物療専門職','その他の医療・保健衛生','福祉・介護','法務',
                    '経営','幼稚園・学校教諭免許','博物館・図書館専門職','専修・各種学校教員','スポーツ等指導',
                    '美術・音楽等','カウンセリング','不動産関連','翻訳・語学','秘書技能'];
                    $category = $array[$_POST['category']];
                    $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
                    $sql = $pdo->prepare('select qual_id,qual_name,add_info from all_qualification where category = ?');
                    $sql->execute([$category]);
                    foreach($sql as $row){
                        echo '<form action="/qualification/public/qual_entry" method="post">';
                        echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
                        echo '<p><input type="hidden" name="qual_id" value="'.$row['qual_id'].'"> ';
                        echo '資格名：<span class="important">'.$row['qual_name'].' </span>';
                        echo '合格日：<input type="date" name="exam_date" required></p>';
                        echo '連絡：<input type="radio" name="announce_flag" value="1">する<input type="radio" name="announce_flag" value="0">しない</p>';
                        echo '<input type="submit" value="登録する"></p><hr>';
                        echo '</form>';
                    }
                    echo '<p>試験当日のアナウンスが必要な場合は、連絡欄を「する」にしてください。</p>';

                }else if(isset($_POST['keyword'])){
                    $keyword = '%'.$_POST['keyword'].'%';
                    $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
                    $sql = $pdo->prepare('select qual_id,qual_name,add_info from all_qualification where qual_name like ?');
                    $sql->execute([$keyword]);
                    foreach($sql as $row){
                        echo '<form action="/qualification/public/expected_qual" method="post">';
                        echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
                        echo '<p><input type="hidden" name="qual_id" value="'.$row['qual_id'].'"> ';
                        echo '資格名：<span class="important">'.$row['qual_name'].' </span>';
                        echo '試験日：<input type="date" name="exam_date" required></p>';
                        echo '連絡：<input type="radio" name="announce_flag" value="1">する<input type="radio" name="announce_flag" value="0">しない</p>';
                        echo '<input type="submit" value="登録する"></p><hr>';
                        echo '</form>';
                    }
                    echo '<p>試験当日のアナウンスが必要な場合は、連絡欄を「する」にしてください。</p>';
                }

            ?>

        <!-- 資格情報を登録する部分 -->
        <?php
            $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
            if(isset($_POST['qual_id'])&&isset($_POST['exam_date'])){
                $sql = $pdo->prepare('insert into expected_qualification values (?,?,?,0,?)');
                $sql ->execute([$_SESSION['user']['user_id'],$_POST['qual_id'],$_POST['exam_date'],$_POST['announce_flag']]);
                
                echo '資格の情報を登録しました。';
            }
        ?>
        <p><a href="/qualification/public/top">資格管理トップ</a></p>
        <p><a href="/qualification/public/qualification">所持資格一覧及び登録情報修正</a></p>
        <p><a href="/qualification/public/qual_entry">所持資格新規登録</a></p>
        <a href="/qualification/public/">ログアウト</a>
    </body>
</html>