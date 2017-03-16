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
      $.post('add.php', {title:title}, function(num){
        var itemStr = $('<div id="js-itemList-'+num+'"data-id="'+num+'" class="ui segment itemList-item"><span></span> <button class="edit ui button">編集</button><button class="delete ui button">完了</button></div>');
        $itemList.append(itemStr).find('div:last span:eq(0)').text(title);
        $inputTask.val('').focus();
      });
    }
  });

  //削除機能
  $(document).on('click', '.delete', function(){
    var id=$(this).parent().data('id');
    $.post("delete.php",
     {
      id:id
     },function(num){
       $('#js-itemList-' + id).remove();
    });
  });

  //編集機能
  $(document).on('click' ,'.edit',function(){
  　　var id= $(this).parent().data('id');
  　　var title = $(this).prev().text();
  　　$('#js-itemList-' + id).empty().append($('<input class="edit-input task-input" type="text">').attr('value',title)).append('<button class="update ui button">更新</button>');
  　　$('#js-itemList-' + id + 'input:eq(0)').focus();
  });

  //更新機能
  $(document).on('click','.update',function(){
  var id = $(this).parent().data('id');
  var title = $(this).prev().val();
   $.post('update.php',{id:id, title:title},function(num){
   var buttonStr = $('<span></span><button class="edit ui button">編集</button><button class="delete ui button">完了</button>');
        $('#js-itemList-'+id).empty().append(buttonStr).find('span:eq(0)').text(title);
     });
    });
});
