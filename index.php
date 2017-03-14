<?php
require_once('config.php');//config.phpを一回読み込み
require_once('function.php');//function.phpを一回読み込み
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.js"></script>

<script>
$(function(){

  var $inputTask = $("#js-input-task");
  var $itemList = $('#js-itemList');

  //入力欄にフォーカス
  $inputTask.focus();

  //追加機能
  $("#js-button-add").click(function(){
    var title = $("#js-input-task").val();

    if($inputTask.val() === ''){
      return false;
    } else {
      $.post('add.php',{title:title},function(rs){
        var itemStr = $('<div id="js-itemList-'+rs+'"data-id="'+rs+'" class="ui segment itemList-item"><span></span> <button class="edit ui button">編集</button><button class="delete ui button">削除</button></div>');
        $itemList.append(itemStr).find('div:last span:eq(0)').text(title);
        $inputTask.val('').focus();
      });
    }

  });

  //削除機能
  $(document).on('click','.delete',function(){
    var id=$(this).parent().data('id');
    $('.ui.basic.modal').modal('show');
    $.post("delete.php",
     {
      id:id
     },function(rs){
       $('#js-itemList-'+id).remove();
    });
  });

  //編集機能
  $(document).on('click' ,'.edit',function(){
  　　var id= $(this).parent().data('id');
  　　var title = $(this).prev().text();
  　　$('#js-itemList-'+id).empty().append($('<input class="edit-input task-input" type="text">').attr('value',title)).append('<button class="update ui button">更新</button>');
  　　$('#js-itemList-'+id+'input:eq(0)').focus();
  });


  //更新機能
  $(document).on('click','.update',function(){
  var id = $(this).parent().data('id');
  var title = $(this).prev().val();
   $.post('update.php',{id:id,title:title},function(rs){
   var buttonStr = $('<span></span><button class="edit ui button">編集</button><button class="delete ui button">削除</button>');
        $('#js-itemList-'+id).empty().append(buttonStr).find('span:eq(0)').text(title);
     });
    });

});
</script>

<style>
.l-container {
  width: 720px;
  margin: 40px auto;
}

.task-input {
  width: 320px!important ;
}

.itemList-item button {
  float: right;
}

.edit-input {
    margin: 0;
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    outline: 0;
    -webkit-tap-highlight-color: rgba(255,255,255,0);
    text-align: left;
    line-height: 1.2142em;
    font-family: Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;
    padding: .67861em 1em;
    background: #fff;
    border: 1px solid rgba(0,0,0,.15);
    color: rgba(0,0,0,.8);
    border-radius: .2857rem;
    -webkit-transition: background-color .2s ease,box-shadow .2s ease,border-color .2s ease;
    transition: background-color .2s ease,box-shadow .2s ease,border-color .2s ease;
    box-shadow: none;
}


</style>

</head>
<body>
<!-- l-container▼ -->
<div class="l-container">
  <h1 class="ui header center aligned">TodoLIST</h1>
  <!-- inputField▼ -->
  <div class="ui center aligned header inputField">
    <div class="ui input">
      <input type="text" id="js-input-task" class="task-input" placeholder="タスクを入力してください">
    </div>
    <input type="button" id="js-button-add" value="追加" class="ui button">
  </div>
  <!-- inputField▲ -->
  <!-- itemList▼ -->
  <div id="js-itemList" class="ui segments itemList">
  <?php foreach($tasks as $task): ?>
    <div id="js-itemList-<?php echo h($task['id']); ?>" class="ui segment itemList-item" data-id="<?php echo h($task['id']); ?>"><span><?php echo h($task['title']); ?></span><button class="edit ui button">編集</button><button class="delete ui button">削除</button></div>
   <?php endforeach; ?>
  </div>
  <!-- itemList▲ -->
</div>
<!-- l-container▲ -->
<!-- modal▼ -->
<div class="ui basic modal">
  <div class="ui icon header">
    <i class="trash outline icon"></i>
    本当に消去しますか？
  </div>
  <div class="ui center aligned header">
    <div id="js-button-delete" class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      No
    </div>
    <div id="js-button-cansel" class="ui green ok inverted button">
        <i class="checkmark icon"></i>
      Yes
    </div>
  </div>
</div>
<!-- modal▲ -->
</body>
</html>
