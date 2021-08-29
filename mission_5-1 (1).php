<!doctype html>
<html>
    <head>
        <meta charset="UTf-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <?php
        //データベースの情報
        $dsn="データベース名";
        $user='ユーザー名';
        $password='パスワード';
        $dsh = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //番号が一致いたときにデータを選択する
        if(isset($_POST["subm"]))
{
        $editnumber = $_POST["editnumber"];
        $sql = 'SELECT * FROM mission5 where id = ?';
        $stmt = $dsh -> prepare($sql);
        $stmt -> execute(array($editnumber));
        //変数に入れたデータを取り出す
        $rec = $stmt -> fetchall(PDO::FETCH_ASSOC);
        //ループさせて番号の一致するデータを取り出す
        foreach($rec as $row)
    {
        $e_num = $row['id'];
        $e_nam = $row['name'];
        $e_com = $row['comment'];
    }
}
        //番号の検索
        if(empty($_POST["search"])==false)
{
        $search_n = $_POST["search"];
        $sql = "SELECT id FROM mission5 where name = ?";
        $stmt = $dsh -> prepare($sql);
        $stmt -> execute(array($search_n));
        $rec = $stmt -> FETCHall(PDO::FETCH_ASSOC);
        foreach($rec as $row)
        {
        $search_num = $row['id'].',';
        }
}
        ?>
        <!--入力フォーム-->
        <form action="" method="post">
            <input type="text" name="name" placeholder="名前を入力" value = "<?php if(isset($e_nam)){echo $e_nam;}?>">
            <br/>
            <input type="text" name="comment" placeholder="好きなゲームは何ですか？" value = "<?php if(isset($e_com)){echo $e_com;}?>">
            <br/>
            <input type="hidden" name="editnum" value="<?php if(isset($e_num)){echo $e_num;} ?>">
            <input type="password" name="pass" placeholder = "パスワードを入力">
            <br/>
            <input type="submit" name="submit" value="送信">
        </form>
        <!--削除フォーム-->
        <form action="" method="post">
            <input type="number" name="number" placeholder="削除番号を入力"><br/>
            <input type = "password" name = "angou" placeholder = "パスワードを入力">
            <br/>
            <input type="submit" name="submi" value="削除">
        </form>
        <!--編集フォーム-->
        <form action = "" method = "post">
        <input type="number" name="editnumber" placeholder="編集番号を入力"><br/>
        <input type = "password" name = "passw" placeholder = "パスワードを入力">
        <br/>
        <input type="submit" name="subm" value="編集">
        </form>
        番号の検索<br/>
        <form action = "" method = "post">
            <input type = "text" name = "search" placeholder = "名前を入力してください"><br/>
            <input type = "submit" name = "sub" value = "検索">
        </form>
        番号はこちらです<br/>
        <form>
            <input type = "<?php if(empty($search_num)){echo "hidden";}else{echo "text";}?>" name = "yourid" value = "<?php if(isset($search_num)){echo $search_num;}?>">
        </form>
        <?php
        //データベースの情報
        $dsn="mysql:dbname=tb230275db;host=localhost";
        $user='tb-230275';
        $password='dSdCPd7kwP';
        $dsh = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //テーブルにデータを挿入
        if(empty($_POST["name"])==false && empty($_POST["comment"])==false && empty($_POST["editnum"]))
{
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $pass = $_POST["pass"];
        $sql = "INSERT INTO mission5 (name,comment,password,col_date) VALUES(:name,:comment,:password,now())";
        $stmt = $dsh -> prepare($sql);
        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt -> bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt -> execute();
}
        //番号が一致した場合にデータの削除を行う
        if(empty($_POST["number"])==false)
{
        $number = $_POST["number"];
        $angou = $_POST["angou"];
        $sql = 'DELETE FROM mission5 where id = ? AND password = ?';
        $stmt = $dsh -> prepare($sql);
        $stmt -> execute(array($number,$angou));
}
        //編集番号が合致したときに更新を行う
        if(empty($_POST["editnum"])==false)
{
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $editnum = $_POST["editnum"];
        $sql = "UPDATE mission5 SET name = :name, comment = :comment, col_date = format(now(),Y/m/d H:i:s) where id = :id AND password = :pass";
        $stmt = $dsh -> prepare($sql);
        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $editnum, PDO::PARAM_INT);
        $stmt -> bindParam(':pass', $passw, PDO::PARAM_STR);
        $stmt -> execute();
}
        ?>
    </body>
</html>