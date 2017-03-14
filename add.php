<?php
require_once('config.php');
require_once('function.php');
$dbh=db_connect();
$sql="INSERT INTO todolist (title,disp) values(:title,1)";
$stmt =$dbh ->prepare($sql);
$stmt->execute(array(":title" => $_POST['title']));
echo $dbh->lastInsertId();
?>
