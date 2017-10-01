<?php
if ($_SESSION['status']!='login') {MessageSend(1, 'Авторизуйтесь пожалуйста.', "/");} else {

$quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$url2."'"))  or die("mySQL connention error");


if ($quiz['author']!=$_SESSION['id']) {MessageSend(1, 'Вы не являетесь создателем данного опроса.', "/");} else {


mysqli_query($MAINBD , "UPDATE `quizzes` SET `status` = 'deleted' WHERE `id` = '".$quiz['id']."'");


MessageSend(3, 'Опрос успешно удален.', "/u/".$_SESSION['id']);

//------------------------------------------------------------------------------------------------------
}}
?>
