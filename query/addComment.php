<?php
if (!$_POST['id']) {MessageSend(2, 'Хех.Ну ты пытался.', '/');} else {
if (!$_POST['text']) {MessageSend(2, 'Вы отправили пустое сообщение', '/'.$_POST['id']);
} else {
  if ($_POST['mainid']) {
    $comment = mysqli_fetch_array(mysqli_query($COMMENTSBD, "SELECT * FROM `".$_POST['tablename']."` WHERE `id` = '".$_POST['mainid']."'"));
    if ($comment['mainid']) {
      $_POST['mainid'] = $comment['mainid'];
    };
  };
$_POST['text'] = nl2br(trim($_POST['text']));
mysqli_query($COMMENTSBD , "INSERT INTO `".$_POST['tablename']."`  VALUES ('','".$_POST['mainid']."','".$_SESSION['id']."', '".$_POST['text']."', NOW(), '".date("H:i:s")."')") or die("Ошибка подключения к базе данных".mysql_error());
MessageSend(2, 'Сообщение отправлено', $_POST['id']);
};};


 ?>
