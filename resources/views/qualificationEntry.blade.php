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
            .important{
                color: red;
                font: bold;
            }
        </style>
    </head>
    <body class="antialiased">
        <?php   
            echo '<h1>My資格管理 所持資格登録</h1>';
            echo $_SESSION['user']['name'].'さんの所持資格を登録してください。';
            //コンテンツをここに記載
        ?>
        <!-- 資格一覧から資格を検索する部分 qual_nameの部分一致かcategoryで検索-->
        <hr>
        <form action="/qualification/public/qual_entry" method="post">
            @csrf
            <p>カテゴリーから検索する</p>
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
        <form action="/qualification/public/qual_entry" method="post">
            @csrf
            <p>資格名から検索する</p>
            <p>資格名の数字は全角で入力してください。</p>
            <input type="text" name="keyword">
            <input type="submit" value="資格名で検索する">
        </form><hr>
        <!-- 資格ID・合格日（必須）などを入力する部分 -->
        
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
                        echo '合格日：<input type="date" name="passed_date" required></p>';
                        echo '<p>更新期限：<input type="date" name="expiration"> ';
                        echo '連絡日：<input type="date" name="announce_date"> ';
                        echo '連絡：<input type="radio" name="announce_flag" value="1">する<input type="radio" name="announce_flag" value="0">しない</p>';
                        $add_text='';
                        if($row['add_info']!==''){
                            $add_text='('.$row['add_info'].')';
                        }
                        echo '<p>自由入力欄'.$add_text.'：<input type="text" name="free_text"> ';
                        echo '<input type="submit" value="登録する"></p><hr>';
                        echo '</form>';
                    }
                    echo '<p>写真の書き換え、免許の更新がある場合は<span class="important">更新期限欄</span>を入力してください。</p>';
                    echo '<p>更新時期のアナウンスが必要な場合は、連絡日を入力し、連絡欄を「する」にしてください。</p>';
                    echo '<p>自由入力欄には、資格の詳細、アピールポイントなど自由に入力してください。</p>';

                }else if(isset($_POST['keyword'])){
                    $keyword = '%'.$_POST['keyword'].'%';
                    $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
                    $sql = $pdo->prepare('select qual_id,qual_name,add_info from all_qualification where qual_name like ?');
                    $sql->execute([$keyword]);
                    foreach($sql as $row){
                        echo '<form action="/qualification/public/qual_entry" method="post">';
                        echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
                        echo '<p><input type="hidden" name="qual_id" value="'.$row['qual_id'].'"> ';
                        echo '資格名：<span class="important">'.$row['qual_name'].' </span>';
                        echo '合格日：<input type="date" name="passed_date" required></p>';
                        echo '<p>更新期限：<input type="date" name="expiration"> ';
                        echo '連絡日：<input type="date" name="announce_date"> ';
                        echo '連絡：<input type="radio" name="announce_flag" value="1">する<input type="radio" name="announce_flag" value="0">しない</p>';
                        $add_text='';
                        if($row['add_info']!==''){
                            $add_text='('.$row['add_info'].')';
                        }
                        echo '<p>自由入力欄'.$add_text.'：<input type="text" name="free_text"> ';
                        echo '<input type="submit" value="登録する"></p><hr>';
                        echo '</form>';
                    }
                    echo '<p>写真の書き換え、免許の更新がある場合は<span class="important">更新期限欄</span>を入力してください。</p>';
                    echo '<p>更新時期のアナウンスが必要な場合は、連絡日を入力し、連絡欄を「する」にしてください。</p>';
                    echo '<p>自由入力欄には、資格の詳細、アピールポイントなど自由に入力してください。</p>';
                }

            ?>

        <!-- 資格情報を登録する部分 -->
        <?php
            $pdo = new PDO("mysql:host=localhost;dbname=qualification;charset=utf8", "user2", "WedWogY.ekqCo.Xm");
            if(isset($_POST['qual_id'])&&isset($_POST['passed_date'])){
                if($_POST['expiration']!==''){
                    $sql = $pdo->prepare('insert into users_qualification values (?,?,?,?,?,?,?,"0")');
                    $sql ->execute([$_SESSION['user']['user_id'],$_POST['qual_id'],$_POST['passed_date'],$_POST['expiration'],$_POST['announce_date'],$_POST['announce_flag'],$_POST['free_text']]);
                }else{
                    $sql = $pdo->prepare('insert into users_qualification (user_id,qual_id,passed_date,add_info) values (?,?,?,?)');
                    $sql ->execute([$_SESSION['user']['user_id'],$_POST['qual_id'],$_POST['passed_date'],$_POST['free_text']]);
                }
                echo '資格の情報を登録しました。';
            }
        ?>
        <?php
            echo '<p><a href="/qualification/public/top">資格管理トップ</a></p>';
            echo '<p><a href="/qualification/public/qualification">所持資格一覧及び登録情報修正</a></p>';
            echo '<p><a href="/qualification/public/expected_qual">受検予定資格登録・修正</a></p>';

            echo '<a href="/qualification/public/">ログアウト</a>';
        ?>
    </body>
</html>