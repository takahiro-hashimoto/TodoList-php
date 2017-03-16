<?php
//MySQLへの接続
function db_connect(){
  try{
  return new PDO(DSN,DB_USER,DB_PASSWORD);
  }catch (PDOException $e){
    echo $e ->getMessage();
    exit;
  }
}
//htmlspecialcharsを使用しやすくするため関数化
function h($s){
  return htmlspecialchars($s,ENT_QUOTES,"UTF-8");
}
?>
