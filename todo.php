<?php header('Content-type: text/html; charset=UTF-8'); ?>
<html>
<body>
<form method="post" action="index.php">
<input type="text" name="todocont" size="30" maxlength="100">
<?php
$prioDisp = 2;    //    表示する優先度    0:低、1:高、2:すべて
$selStr = array( '', '', '' );
$prio = 0;        //    ToDoを追加するときに指定する優先度(0～2)
if(isset( $_POST['priority'] )){
    $prio = (int)$_POST['priority'];
}
if(isset( $_POST['search'])){        //    検索ボタンが押されたか？
    if($prio == 0 || $prio == 1){
        $prioDisp = $prio;
    }
}
$selStr[$prioDisp] = 'selected';    //    優先度セレクトボックスの選択用配列
?>
<select name="priority">
<option value="2" <?php echo $selStr[2]; ?>>すべて
<option value="1" <?php echo $selStr[1]; ?>>高
<option value="0" <?php echo $selStr[0]; ?>>低
</select>
<br><br>
<input type="submit" name="insert" value="追加">
<input type="submit" name="search" value="検索">
<input type="submit" name="delete" value="削除">
<pre>
<?php
//    MySQLに接続する
$dsn = 'mysql:dbname=todo_db;host=localhost;charset=utf8mb4';  // DBへの接続情報
$user = 'root';                                                //    ユーザ名
$password = 'root';                                    //    パスワード
try {
    $dbh = new PDO($dsn, $user, $password);                    //    DBへ接続
} catch (PDOException $e) {
    die('Connect Error: ' . $e->getCode());                    //    DB接続エラー時の処理
}

$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);        //    エミュレート機能をオフ

//    追加ボタンが押されたときの処理
if(isset( $_POST['insert'], $_POST['todocont'] ) && $_POST['todocont'] != ''){
    if($prio < 0 || $prio > 1){    //    優先度が低でも高でもない場合
        $prio = 0;                //    低にする
    }
    $sql = 'INSERT INTO todolist (todo, prio, created) VALUES (?, ?, CURDATE())';
    $sth = $dbh->prepare($sql);
    $sth->bindValue(1, $_POST['todocont'], PDO::PARAM_STR);
    $sth->bindValue(2, $prio, PDO::PARAM_INT);
    $sth->execute();            //    SQL実行
}

//    削除ボタンが押されたときの処理
elseif(isset($_POST['delete'], $_POST['chktodo'])){
    $sql = 'DELETE FROM todolist WHERE id = ?';
    $sth = $dbh->prepare($sql);
    foreach( $_POST['chktodo'] as $chk ){
        $id = (int)$chk;
        $sth->bindValue(1, $id, PDO::PARAM_INT);
        $sth->execute();        //    SQL実行
    }
}

//    TODOリストを表示する
if($prioDisp == 2){                //    すべてのToDoを表示する
    $sql = 'SELECT id, todo FROM todolist';
    $sth = $dbh->prepare($sql);
}
else{                            //    ToDoを優先度で検索して表示する
    $sql = 'SELECT id, todo FROM todolist WHERE prio = ?';
    $sth = $dbh->prepare($sql);
    $sth->bindValue(1, $prioDisp, PDO::PARAM_INT);
}
$sth->execute();                //    SQL実行
while($row = $sth->fetch(PDO::FETCH_ASSOC)){
  echo '<li class="card">';
  echo '<input type="checkbox" name="chktodo[]" value="';
  echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
  echo '">';
  echo htmlspecialchars($row['todo'], ENT_QUOTES, 'UTF-8'), PHP_EOL;
  echo '</li>';
}

$dbh = null;
?>
</pre>
</form>
</body>
</html>
