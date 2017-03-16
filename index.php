<?php
require_once('config.php');
require_once('function.php');
$dbh=db_connect();
$tasks=array();
$sql="SELECT * FROM todolist where disp=1";
foreach($dbh->query($sql) as $row){
  array_push($tasks,$row);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ToDoList</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.css"/>
<link rel="stylesheet" href="css/style.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="script/script.js"></script>
</head>
<body>
<!-- l-container▼ -->
<div class="l-container">
  <h1 class="ui header center aligned">TodoLIST</h1>
  <!-- inputField▼ -->
  <div class="ui segments">
    <div class="ui segment inputField">
      <div class="ui input">
        <input type="text" id="js-input-task" class="task-input" placeholder="タスクを入力してください">
      </div>
      <input type="button" id="js-button-add" value="追加" class="ui button">
    </div>
  </div>
  <!-- inputField▲ -->

  <!-- itemList▼ -->
  <div id="js-itemList" class="ui segments itemList">
  <?php foreach($tasks as $task): ?>
    <div id="js-itemList-<?php echo h($task['id']); ?>" class="ui segment itemList-item" data-id="<?php echo h($task['id']); ?>"><span><?php echo h($task['title']); ?></span><button class="edit ui button">編集</button><button class="delete ui button">完了</button></div>
   <?php endforeach; ?>
  </div>

  <!-- itemList▲ -->
</div>
<!-- l-container▲ -->
</body>
</html>
