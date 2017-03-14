<?php
//MySQLへの接続
function db_connect(){
  try{ //接続をトライ
  return new PDO(DSN,DB_USER,DB_PASSWORD);
  //MySQLへ接続　どこかにDSN,DB_USER,DB_PASSWORDをそれぞれ定義する必要がある
  }catch (PDOException $e){  //接続できなかった場合$eへエラーが格納される
    echo $e ->getMessage();//エラーメッセージを出力
    exit;
  }
}
//htmlspecialcharsを使用しやすくするため関数化
function h($s){
  return htmlspecialchars($s,ENT_QUOTES,"UTF-8");
}
?>
