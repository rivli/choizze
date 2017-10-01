<?php

if (!$_POST['text']) {header("Refresh:0"););
} else {
  if ($_POST['mainid']) {//Этот условный оператор делает главный id главным главного, чтобы строки шли по порядку и не было большой ёлки
    $comment = mysqli_fetch_array(mysqli_query($COMMENTSBD, "SELECT * FROM `".$_POST['tablename']."` WHERE `id` = '".$_POST['mainid']."'"));
    if ($comment['mainid']) {
      $_POST['mainid'] = $comment['mainid'];
    };
  };
$_POST['text'] = nl2br(trim($_POST['text']));
mysqli_query($COMMENTSBD , "INSERT INTO `".$_POST['tablename']."`  VALUES ('','".$_POST['mainid']."','".$_SESSION['id']."', '".$_POST['text']."', NOW(), '".date("H:i:s")."')") or die("Ошибка подключения к базе данных".mysql_error());
//MessageSend(2, 'Сообщение отправлено', $_POST['id']);
header("Refresh:0");
};


 ?>
