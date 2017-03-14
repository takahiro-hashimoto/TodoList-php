<?php
require_once('config.php');
require_once('function.php');
$dbh =db_connect();
$sql ="update todolist set disp = 0 where id=:id";
$stmt = $dbh->prepare($sql);
$stmt -> execute(array(":id" => $_POST['id']));
?>
